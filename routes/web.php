<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CarouselSlideController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;

// Public homepage
Route::get('/', function () {
    $slides = collect(CarouselSlideController::defaultSlides())->map(fn ($slide) => (object) $slide);

    if (auth()->check()) {
        $orgSlides = auth()->user()->organization?->carouselSlides()->orderBy('position')->get();

        if ($orgSlides && $orgSlides->isNotEmpty()) {
            $slides = $orgSlides;
        }
    }

    return view('home', compact('slides'));
})->name('home');

// Guest authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/api/check-organization', [RegisterController::class, 'checkOrganization']);

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

    // Role dashboard routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::put('/admin/organization/name', [AdminController::class, 'updateOrganizationName'])->name('admin.organization.update-name');
        Route::put('/admin/users/{targetUser}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.update-role');
        Route::put('/admin/users/{targetUser}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
        Route::post('/admin/carousel/slides', [AdminController::class, 'storeSlide'])->name('admin.carousel.store');
        Route::put('/admin/carousel/slides/{slide}', [AdminController::class, 'updateSlide'])->name('admin.carousel.update-slide');
        Route::delete('/admin/carousel/slides/{slide}', [AdminController::class, 'destroySlide'])->name('admin.carousel.destroy-slide');
        Route::post('/admin/nests', [AdminController::class, 'createNest'])->name('admin.nests.create');

        Route::get('/admin/carousel', [CarouselSlideController::class, 'edit'])->name('admin.carousel.edit');
        Route::put('/admin/carousel', [CarouselSlideController::class, 'update'])->name('admin.carousel.update');
        Route::post('/admin/organization/delete', [AdminController::class, 'deleteOrganization'])->name('admin.organization.delete');
    });

    Route::middleware('role:ceo')->group(function () {
        Route::get('/ceo/dashboard', function () {
            return view('ceo.dashboard', [
                'user' => auth()->user(),
                'organization' => auth()->user()->organization
            ]);
        })->name('ceo.dashboard');
    });

    Route::middleware('role:hr')->group(function () {
        Route::get('/hr/dashboard', [HRController::class, 'dashboard'])->name('hr.dashboard');
    });

    // HR Module Routes (accessible to HR and Admin)
    Route::middleware('role:hr,admin')->group(function () {
        Route::get('/hr/departments', [DepartmentController::class, 'index'])->name('hr.departments.index');
        Route::post('/hr/departments', [DepartmentController::class, 'store'])->name('hr.departments.store');
        Route::put('/hr/departments/{department}', [DepartmentController::class, 'update'])->name('hr.departments.update');
        Route::delete('/hr/departments/{department}', [DepartmentController::class, 'destroy'])->name('hr.departments.destroy');

        Route::get('/hr/employees', [EmployeeController::class, 'index'])->name('hr.employees.index');
        Route::get('/hr/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('hr.employees.edit');
        Route::put('/hr/employees/{employee}', [EmployeeController::class, 'update'])->name('hr.employees.update');
    });

    Route::middleware('role:manager')->group(function () {
        Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    });

    Route::middleware('role:employee')->group(function () {
        Route::get('/employee/dashboard', function () {
            return view('employee.dashboard', [
                'user' => auth()->user(),
                'organization' => auth()->user()->organization
            ]);
        })->name('employee.dashboard');
    });

    Route::middleware('role:support')->group(function () {
        Route::get('/support/dashboard', function () {
            return view('support.dashboard', [
                'user' => auth()->user(),
                'organization' => auth()->user()->organization
            ]);
        })->name('support.dashboard');
    });
});
