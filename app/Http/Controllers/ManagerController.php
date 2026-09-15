<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    /**
     * Display the Manager dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $organization = $user->organization;

        return view('manager.dashboard', compact('user', 'organization'));
    }
}
