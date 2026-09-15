<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user and their organization are active
        if (!$user->is_active || ($user->status ?? 'active') === 'inactive' || ($user->organization && !$user->organization->is_active)) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Your account or organization has been deactivated.',
            ]);
        }

        $allowedRoles = [];
        foreach ($roles as $role) {
            foreach (explode(',', $role) as $r) {
                $allowedRoles[] = strtolower(trim($r));
            }
        }

        $userRole = strtolower(trim($user->role ?? 'employee'));

        if (!in_array($userRole, $allowedRoles)) {
            $targetPath = "{$userRole}/dashboard";
            if ($request->is($targetPath)) {
                return $next($request);
            }
            return redirect()->to("/{$targetPath}");
        }

        return $next($request);
    }
}
