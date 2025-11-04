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

Route::get('/', fn() => redirect()->route('login'));

// ------------------------
// Auth Routes
// ------------------------
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

// ------------------------
// Admin Routes
// ------------------------
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile/edit', [AdminController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminController::class, 'update'])->name('profile.update');

    // Users
    Route::resource('users', AdminController::class);
    Route::post('/users/bulk-delete', [AdminController::class, 'bulkDelete'])->name('users.bulkDelete');
    Route::post('/users/{user}/remove-avatar', [AdminController::class, 'removeAvatar'])->name('users.removeAvatar');

    // ------------------------
    // Students
    // ------------------------
    Route::resource('students', StudentController::class);

    // Assign school
    Route::post('/students/{student}/assign-school', [StudentController::class, 'assignSchool'])->name('students.assignSchool');

    // Grades - AJAX
    Route::get('/students/{student}/grades-sections/{school}', [StudentController::class, 'gradesSections'])->name('students.gradesSections');
    Route::post('/students/{student}/storegrades', [StudentController::class, 'storeGrade'])->name('students.storeGrade');
    Route::get('/students/{student}/load-grades', [StudentController::class, 'loadGrades'])->name('students.loadGrades');
    Route::put('/students/{student}/updategrades', [StudentController::class, 'updateGrades']);
    Route::post('/students/{student}/updategrades', [StudentController::class, 'updateGradesInline'])->name('students.updateGradesInline');
    Route::delete('/students/{student}/grades/{grade}', [StudentController::class, 'destroyGrade'])->name('students.destroyGrade');

    // ------------------------
    // Locations (Country / State / School)
    // ------------------------
    Route::get('/countries/{country}/states', [StateController::class, 'getByCountry'])->name('countries.states');
    Route::get('/states/{state}/schools', [SchoolController::class, 'getByState'])->name('states.schools');

    Route::resource('countries', CountryController::class);
    Route::resource('states', StateController::class);
    Route::resource('schools', SchoolController::class);
    Route::resource('schools.classes', ClassController::class);
    Route::resource('schools.subjects', SubjectController::class);
});
