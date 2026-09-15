<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DeveloperController extends Controller
{
    /**
     * Display the Developer dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $organization = $user->organization;

        return view('developer.dashboard', compact('user', 'organization'));
    }
}
