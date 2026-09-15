<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CarouselSlideController;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Check if an organization name exists (AJAX endpoint).
     */
    public function checkOrganization(Request $request)
    {
        $name = trim($request->query('name', ''));
        if (empty($name)) {
            return response()->json(['exists' => false]);
        }
        $exists = Organization::where('name', $name)
            ->orWhereRaw('LOWER(name) = ?', [strtolower($name)])
            ->exists();
        return response()->json(['exists' => $exists]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $orgName = trim($request->organization_name ?? '');

        // Check if organization exists (case-insensitive)
        $existingOrg = Organization::where('name', $orgName)
            ->orWhereRaw('LOWER(name) = ?', [strtolower($orgName)])
            ->first();

        $orgExists = (bool) $existingOrg;

        // If user submitted role/department when org does not exist, show clear error
        $userIntendingToJoin = $request->filled('role') || $request->filled('department');

        if ($userIntendingToJoin && !$orgExists) {
            return back()->withErrors([
                'organization_name' => 'This organization is not registered yet. Please ask your Admin to register first.'
            ])->withInput();
        }

        $rules = [
            'organization_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if ($orgExists) {
            $rules['role'] = ['required', Rule::in(['CEO', 'HR', 'Manager', 'Employee', 'Support'])];
            $rules['department'] = ['required', Rule::in(['Engineering', 'Finance', 'HR', 'Marketing', 'Operations', 'Sales'])];
        }

        $request->validate($rules);

        if (!$orgExists) {
            $slug = Str::slug($orgName);

            // Create new organization for founder
            $organization = Organization::create([
                'name' => $orgName,
                'slug' => $slug,
                'is_active' => true,
            ]);

            CarouselSlideController::seedDefaultSlides($organization);

            $role = 'admin';
            $department = 'Admin';
        } else {
            if (!$existingOrg->is_active) {
                return back()->withErrors([
                    'organization_name' => 'This organization has been deactivated.'
                ])->withInput();
            }

            $organization = $existingOrg;
            $role = $request->role;
            $department = $request->department;
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => $organization->id,
            'department' => $department,
            'role' => $role,
            'is_active' => true,
        ]);

        Auth::login($user);

        $dashboardPath = strtolower($user->role) . '/dashboard';

        return redirect()->to($dashboardPath);
    }
}
