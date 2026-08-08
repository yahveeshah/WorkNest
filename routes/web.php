<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WorkNest Web Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/forgot-password', function () {
    return view('auth.login'); // or auth.forgot-password
});

Route::get('/components-guide', function () {
    return redirect('/worknest-frontend/components-guide.html');
});

// Admin Routes
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

// CEO Routes
Route::get('/ceo/dashboard', function () {
    return redirect('/worknest-frontend/pages/ceo/dashboard.html');
});

// HR Routes
Route::get('/hr/dashboard', function () {
    return redirect('/worknest-frontend/pages/hr/dashboard.html');
});

Route::get('/hr/employees', function () {
    return redirect('/worknest-frontend/pages/hr/employees.html');
});

// Manager Routes
Route::get('/manager/dashboard', function () {
    return redirect('/worknest-frontend/pages/manager/dashboard.html');
});

Route::get('/manager/tasks', function () {
    return redirect('/worknest-frontend/pages/manager/tasks.html');
});

// Employee Routes
Route::get('/employee/dashboard', function () {
    return redirect('/worknest-frontend/pages/employee/dashboard.html');
});

Route::get('/employee/attendance', function () {
    return redirect('/worknest-frontend/pages/employee/attendance.html');
});

Route::get('/employee/leave', function () {
    return redirect('/worknest-frontend/pages/employee/leave.html');
});

// Support Routes
Route::get('/support/dashboard', function () {
    return redirect('/worknest-frontend/pages/support/dashboard.html');
});

// Shared Routes
Route::get('/shared/profile', function () {
    return redirect('/worknest-frontend/pages/shared/profile.html');
});
