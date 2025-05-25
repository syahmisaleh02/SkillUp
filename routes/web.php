<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EmployeeAttendanceController;

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
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', function () {
        return view('manager.dashboard');
    })->name('dashboard');
    
    Route::get('/team', [CourseController::class, 'employeeProgressOverview'])->name('team');

    // Employee Progress Overview
    Route::get('/team/progress', [CourseController::class, 'employeeProgressOverview'])->name('team.progress.overview');

    // Course Management Routes
    Route::get('/course', [CourseController::class, 'index'])->name('course');
    Route::get('/course/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('/course', [CourseController::class, 'store'])->name('course.store');
    Route::get('/course/{id}/edit', [CourseController::class, 'edit'])->name('course.edit');
    Route::put('/course/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::delete('/course/{id}', [CourseController::class, 'destroy'])->name('course.destroy');
    Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.show');
    Route::get('/course/{id}/assign', [CourseController::class, 'showAssignCourse'])->name('course.assign');
    Route::get('/course/{courseId}/assign/show', [CourseController::class, 'showAssignCourse'])->name('course.assign.show');
    Route::post('/course/{courseId}/assign/{employeeId}', [CourseController::class, 'assignCourse'])->name('course.assign.store');
    Route::delete('/course/{courseId}/assign/{employeeId}', [CourseController::class, 'removeCourseAssignment'])->name('course.assign.remove');
    Route::get('/employee/progress/{id}', [CourseController::class, 'getEmployeeProgress'])->name('employee.progress');

    // Course Assignment Routes
    Route::post('/course/material', [CourseController::class, 'storeMaterial'])->name('course.material.store');
    Route::delete('/course/material/{courseId}/{materialIndex}', [CourseController::class, 'deleteMaterial'])->name('course.material.delete');

    // Course Data Routes
    Route::get('/course-data', [CourseController::class, 'courseData'])->name('course.data');
    Route::get('/course-data/{id}', [CourseController::class, 'courseDataDetails'])->name('course.data.details');
    Route::get('/course-data/{id}/report', [CourseController::class, 'generateReport'])->name('course.data.report');
});

// Employee Routes
Route::middleware(['auth', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', function () {
        return view('employee.dashboard');
    })->name('dashboard');
    
    Route::get('/courses', [CourseController::class, 'employeeCourses'])->name('courses');
    Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.view');
    
    // Attendance Routes
    Route::get('/attendance', [EmployeeAttendanceController::class, 'index'])->name('attendance');
    Route::post('/attendance/sign', [EmployeeAttendanceController::class, 'signAttendance'])->name('attendance.sign');

    Route::post('/course/{id}/join', [CourseController::class, 'employeeJoinCourse'])->name('course.join');
    Route::delete('/course/{id}/unenroll', [CourseController::class, 'employeeUnenrollCourse'])->name('course.unenroll');
    Route::post('/course/{courseId}/material/{materialIndex}/complete', [CourseController::class, 'markMaterialCompleted'])->name('course.material.complete');
});

// Profile Route (accessible by all users)
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
