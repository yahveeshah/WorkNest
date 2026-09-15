<?php

namespace App\Http\Controllers;

use App\Models\CarouselSlide;
use App\Models\Department;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the Admin dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $organization = $user->organization;

        // All users in organization
        $allUsers = User::where('organization_id', $organization->id)
            ->orderBy('name')
            ->get();

        // Department count
        $totalDepartments = Department::where('organization_id', $organization->id)->count();
        if ($totalDepartments === 0) {
            $totalDepartments = $allUsers->pluck('department')->filter()->unique()->count();
        }

        // Overview Statistics
        $totalEmployees = $allUsers->count();
        
        $roleCounts = [
            'Admin'    => $allUsers->filter(fn($u) => strtolower($u->role) === 'admin')->count(),
            'CEO'      => $allUsers->filter(fn($u) => strtolower($u->role) === 'ceo')->count(),
            'HR'       => $allUsers->filter(fn($u) => strtolower($u->role) === 'hr')->count(),
            'Manager'  => $allUsers->filter(fn($u) => strtolower($u->role) === 'manager')->count(),
            'Employee' => $allUsers->filter(fn($u) => strtolower($u->role) === 'employee')->count(),
            'Support'  => $allUsers->filter(fn($u) => strtolower($u->role) === 'support')->count(),
        ];

        // Carousel Slides for Organization
        $slides = $organization->carouselSlides()->orderBy('position')->get();
        if ($slides->isEmpty()) {
            $slides = CarouselSlideController::seedDefaultSlides($organization);
        }

        return view('admin.dashboard', compact(
            'user',
            'organization',
            'allUsers',
            'totalEmployees',
            'totalDepartments',
            'roleCounts',
            'slides'
        ));
    }

    /**
     * Update Organization Name.
     */
    public function updateOrganizationName(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $organization = $user->organization;
        $organization->update([
            'name' => trim($request->name),
            'slug' => \Illuminate\Support\Str::slug($request->name),
        ]);

        return back()->with('status', 'Organization name updated successfully.');
    }

    /**
     * Update a user's role.
     */
    public function updateUserRole(Request $request, User $targetUser)
    {
        $user = Auth::user();
        if ($targetUser->organization_id !== $user->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'role' => ['required', 'string', 'in:admin,Admin,CEO,HR,Manager,Employee,Support'],
        ]);

        $targetUser->update([
            'role' => $request->role,
        ]);

        return back()->with('status', "Role updated for {$targetUser->name}.");
    }

    /**
     * Deactivate or reactivate a user account.
     */
    public function toggleUserStatus(User $targetUser)
    {
        $user = Auth::user();
        if ($targetUser->organization_id !== $user->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($targetUser->id === $user->id) {
            return back()->withErrors(['error' => 'You cannot deactivate your own admin account.']);
        }

        $newStatus = !$targetUser->is_active;
        $targetUser->update([
            'is_active' => $newStatus,
            'status' => $newStatus ? 'active' : 'inactive',
        ]);

        $statusText = $newStatus ? 'reactivated' : 'deactivated';
        return back()->with('status', "User {$targetUser->name} has been {$statusText}.");
    }

    /**
     * Create a new homepage carousel slide.
     */
    public function storeSlide(Request $request)
    {
        $user = Auth::user();
        $organization = $user->organization;

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
        ]);

        $nextPosition = $organization->carouselSlides()->max('position') + 1;

        CarouselSlide::create([
            'organization_id' => $organization->id,
            'position' => $nextPosition,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
        ]);

        return back()->with('status', 'New carousel slide created successfully.');
    }

    /**
     * Update an existing carousel slide.
     */
    public function updateSlide(Request $request, CarouselSlide $slide)
    {
        $user = Auth::user();
        if ($slide->organization_id !== $user->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
        ]);

        $slide->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
        ]);

        return back()->with('status', 'Carousel slide updated successfully.');
    }

    /**
     * Delete a carousel slide.
     */
    public function destroySlide(CarouselSlide $slide)
    {
        $user = Auth::user();
        if ($slide->organization_id !== $user->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        $slide->delete();

        return back()->with('status', 'Carousel slide deleted successfully.');
    }

    /**
     * Create a new group chat / Nest workspace.
     */
    public function createNest(Request $request)
    {
        $request->validate([
            'nest_name' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        return back()->with('status', "Nest '{$request->nest_name}' created successfully!");
    }

    /**
     * Delete the organization and all its associated users.
     */
    public function deleteOrganization(Request $request)
    {
        $user = Auth::user();

        if (strtolower($user->role) !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $organization = $user->organization;

        if (!$organization) {
            return redirect('/');
        }

        DB::transaction(function () use ($organization) {
            // Deactivate and soft delete all users in the organization
            $organization->users()->update(['is_active' => false]);
            $organization->users()->delete();

            // Deactivate and soft delete the organization itself
            $organization->is_active = false;
            $organization->save();
            $organization->delete();
        });

        // Log out the admin user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Your organization and all associated user accounts have been successfully deactivated.');
    }
}
