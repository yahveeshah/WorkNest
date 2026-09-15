<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming login request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'organization_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Find the organization
        $organization = Organization::where('name', $request->organization_name)->first();

        if (!$organization) {
            return back()->withErrors([
                'organization_name' => 'This organization is not registered.'
            ])->withInput($request->only('organization_name', 'email'));
        }

        if (!$organization->is_active) {
            return back()->withErrors([
                'organization_name' => 'Your organization has been deactivated.'
            ])->withInput($request->only('organization_name', 'email'));
        }

        // Find the user to check if they are active
        $user = User::where('email', $request->email)
            ->where('organization_id', $organization->id)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'These credentials do not match our records.'
            ])->withInput($request->only('organization_name', 'email'));
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Your account has been deactivated.'
            ])->withInput($request->only('organization_name', 'email'));
        }

        // Attempt login
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'organization_id' => $organization->id,
            'is_active' => true,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $dashboardPath = strtolower($user->role) . '/dashboard';
            return redirect()->intended($dashboardPath);
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.'
        ])->withInput($request->only('organization_name', 'email'));
    }
}
