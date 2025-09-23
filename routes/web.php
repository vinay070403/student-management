<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['web', 'redirect.if.authenticated'])->group(function () {

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth'); // Enforce POST and auth;
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users')->middleware('permission:user-list');
    Route::get('/admin/users/create', [AdminController::class, 'create'])->name('admin.users.create')->middleware('permission:user-list');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store')->middleware('permission:user-list');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy')->middleware('permission:user-list');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit')->middleware('permission:user-list');
    Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update')->middleware('permission:user-list');
    Route::get('/admin/schools', [AdminController::class, 'schools'])->name('admin.schools')->middleware('permission:school-list');
    // Add more admin routes here if needed
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/students', [StudentController::class, 'index'])->name('students.index')->middleware('permission:user-list');
    Route::get('/admin/students/create', [StudentController::class, 'create'])->name('students.create')->middleware('permission:user-list');
    Route::post('/admin/students', [StudentController::class, 'store'])->name('students.store')->middleware('permission:user-list');
    Route::get('/admin/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit')->middleware('permission:user-list');
    Route::put('/admin/students/{student}', [StudentController::class, 'update'])->name('students.update')->middleware('permission:user-list');
    Route::delete('/admin/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy')->middleware('permission:user-list');
});

// });
