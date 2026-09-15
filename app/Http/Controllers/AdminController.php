<?php

namespace App\Http\Controllers;

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
        
        // Get all members of this organization except the current user
        $members = $organization->users()
            ->where('id', '!=', $user->id)
            ->get();

        return view('admin.dashboard', compact('user', 'organization', 'members'));
    }

    /**
     * Delete the organization and all its associated users.
     */
    public function deleteOrganization(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
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
