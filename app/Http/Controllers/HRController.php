<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HRController extends Controller
{
    /**
     * Display the HR dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $organization = $user->organization;

        return view('hr.dashboard', compact('user', 'organization'));
    }
}
