<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    /**
     * Display the Finance dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $organization = $user->organization;

        return view('finance.dashboard', compact('user', 'organization'));
    }
}
