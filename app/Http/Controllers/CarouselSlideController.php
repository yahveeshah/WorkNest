<?php

namespace App\Http\Controllers;

use App\Models\CarouselSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarouselSlideController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $organization = $user->organization;
        $slides = $organization->carouselSlides()->orderBy('position')->get();

        if ($slides->isEmpty()) {
            $slides = $this->seedDefaultSlides($organization);
        }

        return view('admin.carousel', compact('user', 'organization', 'slides'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $organization = $user->organization;

        $validated = $request->validate([
            'slides' => ['required', 'array', 'size:3'],
            'slides.*.title' => ['required', 'string', 'max:255'],
            'slides.*.subtitle' => ['nullable', 'string', 'max:255'],
            'slides.*.description' => ['required', 'string', 'max:1000'],
        ]);

        foreach ($validated['slides'] as $index => $slideData) {
            CarouselSlide::updateOrCreate(
                [
                    'organization_id' => $organization->id,
                    'position' => $index + 1,
                ],
                [
                    'title' => $slideData['title'],
                    'subtitle' => $slideData['subtitle'] ?? null,
                    'description' => $slideData['description'],
                ]
            );
        }

        return redirect()
            ->route('admin.carousel.edit')
            ->with('status', 'Carousel slides updated successfully.');
    }

    public static function defaultSlides(): array
    {
        return [
            [
                'title' => 'Organization clarity',
                'subtitle' => null,
                'description' => 'Bring employee information and department membership into one dependable organization workspace.',
            ],
            [
                'title' => 'Focused department access',
                'subtitle' => null,
                'description' => 'Each employee enters the workspace that aligns with their department and responsibilities.',
            ],
            [
                'title' => 'Structured growth',
                'subtitle' => null,
                'description' => 'Support new teams with a clear registration process and a consistent foundation for operations.',
            ],
        ];
    }

    public static function seedDefaultSlides($organization)
    {
        $slides = collect();

        foreach (self::defaultSlides() as $index => $slideData) {
            $slides->push(CarouselSlide::create([
                'organization_id' => $organization->id,
                'position' => $index + 1,
                'title' => $slideData['title'],
                'subtitle' => $slideData['subtitle'],
                'description' => $slideData['description'],
            ]));
        }

        return $slides;
    }
}
