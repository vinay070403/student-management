<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolePermissionViewController;

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

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

// ------------------------
// Admin Routes
// ------------------------
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::resource('users', UserController::class)->parameters([
        'users' => 'user:ulid',
    ]);

    // STATUS TOGGLE (THIS ONE)
    Route::post('/users/change-status/{id}', [UserController::class, 'updateStatus'])
        ->name('users.change-status');

    // custom route for status update
    Route::post('users/update-status', [UserController::class, 'updateStatus'])->name('admin.users.updateStatus');
    Route::post('/users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulkDelete');
    Route::post('/users/{user}/remove-avatar', [UserController::class, 'removeAvatar'])->name('users.removeAvatar');
    // ------------------------
    // Students
    // ------------------------
    Route::resource('students', StudentController::class);
    // Assign school
    Route::post('/students/{student}/assign-school', [StudentController::class, 'assignSchool'])->name('students.assignSchool');
    // Grades - AJAX
    Route::get('/students/{student}/grades-sections/{school}', [StudentController::class, 'gradesSections'])->name('students.gradesSections');
    // Route::post('/students/{student}/storegrades', [StudentController::class, 'storeGrade'])->name('students.storeGrade');
    Route::post('/students/{student}/storegrades', [StudentController::class, 'storeGrades'])->name('students.storeGrades');
    Route::get('/students/{student}/load-grades', [StudentController::class, 'loadGrades'])->name('students.loadGrades');
    Route::post('/students/{student}/updategrades', [StudentController::class, 'updateGradesInline'])->name('students.updateGradesInline');
    Route::post('/students/{student}/delete-class', [StudentController::class, 'deleteClass']);
    Route::post('/students/{student}/delete-subject', [StudentController::class, 'deleteSubject']);
    Route::delete('/students/{student}/grades/{grade}', [StudentController::class, 'destroyGrade'])->name('students.destroyGrade');
    // ------------------------
    // Locations (Country / State / School)
    // ------------------------
    Route::get('/countries/{country}/states', [StateController::class, 'getByCountry'])->name('countries.states');
    Route::get('/states/{state}/schools', [SchoolController::class, 'getByState'])->name('states.schools');

    Route::resource('countries', CountryController::class)->parameters([
        'countries' => 'country:ulid',
    ]);
    Route::delete('countries/bulk-delete', [CountryController::class, 'bulkDelete'])->name('countries.bulkDelete');

    Route::resource('states', StateController::class)->parameters([
        'states' => 'state:ulid',
    ]);
    Route::resource('schools', SchoolController::class)->parameters([
        'schools' => 'school:ulid',
    ]);

    Route::resource('schools.classes', ClassController::class)->scoped([
        'class' => 'ulid'
    ]);
    Route::delete('schools/{school}/classes/{class}', [ClassController::class, 'destroy'])
        ->name('schools.classes.destroy');


    Route::resource('schools.subjects', SubjectController::class)->parameters([
        'subjects' => 'subject:ulid',
    ]);

    // Roles & Permissions Main Index (3 Tabs)
    Route::get('roles-permission', [RolePermissionViewController::class, 'index'])
        ->name('rolesPermission.index');

    // Roles CRUD
    Route::resource('roles', RoleController::class);

    // Permission Groups CRUD
    Route::resource('permission-groups', PermissionGroupController::class);

    // Permissions CRUD
    Route::resource('permissions', PermissionController::class);
});
