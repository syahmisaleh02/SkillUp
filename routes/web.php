<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// Welcome Page (this will also serve as the login page)
Route::get('/', function () {
    return view('auth.login');
})->name('welcome');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login'); // Show login form
    Route::post('/login', 'loginAction')->name('login.action'); // Handle login form submission
    Route::get('/register', 'register')->name('register'); // Show registration form
    Route::post('/register', 'registerSave')->name('register.save'); // Handle registration action
    Route::get('/logout', 'logout')->name('logout'); // Handle logout action
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::put('/users/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
});

// Manager Routes
Route::prefix('manager')->group(function () {
    Route::get('/dashboard', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');
    
    Route::get('/team', function () {
        return view('manager.team');
    })->name('manager.team');

    Route::get('/course', function () {
        return view('manager.course');
    })->name('manager.course');

    Route::get('/course/{id}/edit', function () {
        return view('manager.course-edit');
    })->name('manager.course.edit');

    Route::get('/team/{id}/assign-course', function () {
        return view('manager.assign-course');
    })->name('manager.team.assign-course');

    Route::get('/team/{id}/progress', function () {
        return view('manager.employee-progress');
    })->name('manager.team.progress');
});

// Employee Routes
Route::prefix('employee')->group(function () {
    Route::get('/dashboard', function () {
        return view('employee.dashboard');
    })->name('employee.dashboard');

    Route::get('/courses', function () {
        return view('employee.courses');
    })->name('employee.courses');

    Route::get('/attendance', function () {
        return view('employee.attendance');
    })->name('employee.attendance');

    Route::get('/available-courses', function () {
        return view('employee.available-courses');
    })->name('employee.available-courses');

    Route::get('/course/{id}', function ($id) {
        return view('employee.course-view', ['courseId' => $id]);
    })->name('employee.course.view');
});

// Profile Route (accessible by all users)
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
