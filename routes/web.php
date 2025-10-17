<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ProfileController;

// -----------------------------
// Public Routes
// -----------------------------
Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Users (with extra bulk delete route)
    Route::resource('users', AdminController::class);
    Route::post('/users/bulk-delete', [AdminController::class, 'bulkDelete'])->name('users.bulkDelete');
    Route::post('/admin/users/{user}/remove-avatar', [AdminController::class, 'removeAvatar'])->name('users.removeAvatar');



    // Students
    Route::resource('students', StudentController::class);

    // Countries
    Route::resource('countries', CountryController::class);

    // States
    Route::resource('states', StateController::class);

    // Schools
    Route::resource('schools', SchoolController::class);

    // Nested: Classes inside Schools
    Route::resource('schools.classes', ClassController::class);

    // Nested: Subjects inside Schools
    Route::resource('schools.subjects', SubjectController::class);
});
