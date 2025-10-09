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
    Route::post('/admin/users/bulk-delete', [AdminController::class, 'bulkDelete'])->name('admin.users.bulkDelete');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit')->middleware('permission:user-list');
    Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update')->middleware('permission:user-list');
    // Route::get('/admin/schools', [AdminController::class, 'schools'])->name('admin.schools')->middleware('permission:school-list');
    // Add more admin routes here if needed

    Route::get('/admin/students', [StudentController::class, 'index'])->name('students.index')->middleware('permission:user-list');
    Route::get('/admin/students/create', [StudentController::class, 'create'])->name('students.create')->middleware('permission:user-list');
    Route::post('/admin/students', [StudentController::class, 'store'])->name('students.store')->middleware('permission:user-list');
    Route::get('/admin/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit')->middleware('permission:user-list');
    Route::put('/admin/students/{student}', [StudentController::class, 'update'])->name('students.update')->middleware('permission:user-list');
    Route::delete('/admin/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy')->middleware('permission:user-list');
    // Add more student routes here if needed
    Route::get('/admin/countries', [CountryController::class, 'index'])->name('countries.index')->middleware('permission:country-list');
    Route::get('/admin/countries/create', [CountryController::class, 'create'])->name('countries.create')->middleware('permission:country-list');
    Route::post('/admin/countries', [CountryController::class, 'store'])->name('countries.store')->middleware('permission:country-list');
    Route::get('/admin/countries/{country}/edit', [CountryController::class, 'edit'])->name('countries.edit')->middleware('permission:country-list');
    Route::put('/admin/countries/{country}', [CountryController::class, 'update'])->name('countries.update')->middleware('permission:country-list');
    Route::delete('/admin/countries/{country}', [CountryController::class, 'destroy'])->name('countries.destroy')->middleware('permission:country-list');

    Route::get('/admin/states', [StateController::class, 'index'])->name('states.index')->middleware('permission:state-list');
    Route::get('/admin/states/create', [StateController::class, 'create'])->name('states.create')->middleware('permission:state-list');
    Route::post('/admin/states', [StateController::class, 'store'])->name('states.store')->middleware('permission:state-list');
    Route::get('/admin/states/{state}/edit', [StateController::class, 'edit'])->name('states.edit')->middleware('permission:state-list');
    Route::put('/admin/states/{state}', [StateController::class, 'update'])->name('states.update')->middleware('permission:state-list');
    Route::delete('/admin/states/{state}', [StateController::class, 'destroy'])->name('states.destroy')->middleware('permission:state-list');

    Route::get('/admin/schools', [SchoolController::class, 'index'])->name('schools.index')->middleware('permission:school-list');
    Route::get('/admin/schools/create', [SchoolController::class, 'create'])->name('schools.create')->middleware('permission:school-list');
    Route::post('/admin/schools', [SchoolController::class, 'store'])->name('schools.store')->middleware('permission:school-list');
    Route::get('/admin/schools/{school}/edit', [SchoolController::class, 'edit'])->name('schools.edit')->middleware('permission:school-list');
    Route::put('/admin/schools/{school}', [SchoolController::class, 'update'])->name('schools.update')->middleware('permission:school-list');
    Route::delete('/admin/schools/{school}', [SchoolController::class, 'destroy'])->name('schools.destroy')->middleware('permission:school-list');

    // Scoped Classes and Subjects (no global routes)
    // Classes
    Route::get('/admin/schools/{school}/classes', [ClassController::class, 'index'])->name('schools.classes.index')->middleware('permission:class-list');
    Route::get('/admin/schools/{school}/classes/create', [ClassController::class, 'create'])->name('schools.classes.create')->middleware('permission:class-list');
    Route::post('/admin/schools/{school}/classes', [ClassController::class, 'store'])->name('schools.classes.store')->middleware('permission:class-list');
    Route::get('/admin/schools/{school}/classes/{class}/edit', [ClassController::class, 'edit'])->name('schools.classes.edit')->middleware('permission:class-list');
    Route::put('/admin/schools/{school}/classes/{class}', [ClassController::class, 'update'])->name('schools.classes.update')->middleware('permission:class-list');
    Route::delete('/admin/schools/{school}/classes/{class}', [ClassController::class, 'destroy'])->name('schools.classes.destroy')->middleware('permission:class-list');

    // Subjects (similar)
    Route::get('/admin/schools/{school}/subjects', [SubjectController::class, 'index'])->name('schools.subjects.index')->middleware('permission:subject-list');
    Route::get('/admin/schools/{school}/subjects/create', [SubjectController::class, 'create'])->name('schools.subjects.create')->middleware('permission:subject-list');
    Route::post('/admin/schools/{school}/subjects', [SubjectController::class, 'store'])->name('schools.subjects.store')->middleware('permission:subject-list');
    Route::get('/admin/schools/{school}/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('schools.subjects.edit')->middleware('permission:subject-list');
    Route::put('/admin/schools/{school}/subjects/{subject}', [SubjectController::class, 'update'])->name('schools.subjects.update')->middleware('permission:subject-list');
    Route::delete('/admin/schools/{school}/subjects/{subject}', [SubjectController::class, 'destroy'])->name('schools.subjects.destroy')->middleware('permission:subject-list');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// });
