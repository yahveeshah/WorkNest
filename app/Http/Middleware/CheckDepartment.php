<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDepartment
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $department): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user and their organization are active
        if (!$user->is_active || ($user->organization && !$user->organization->is_active)) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Your account or organization has been deactivated.',
            ]);
        }

        if (strtolower($user->department) !== strtolower($department)) {
            $userDept = strtolower($user->department);
            return redirect()->to("/{$userDept}/dashboard");
        }

        return $next($request);
    }
}
