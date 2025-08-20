<?php

use App\DTOs\UserDTO;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\User;
use App\services\UserServices;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', WelcomeController::class)->name('home');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('create-user', [UserController::class, 'show'])->name('user.show');

Route::post('create-user', [UserController::class, 'create'])->name('user.create');

/**
 * TODO: Rutas para Teachers
 */

Route::get('/teacher/index', [TeacherController::class, 'index']);

Route::get('/teacher/create', [TeacherController::class, 'create']);
Route::post('/teacher/create', [TeacherController::class, 'store'])->name('teacher.create');

Route::get('/teacher/edit/{id}', [TeacherController::class, 'edit']);
Route::get('/teacher/update/{id}', [TeacherController::class, 'update'])->name('teaceher.update');

/**
 * TODO: Rutas para Students
 */

Route::get('/student/index', [StudentController::class, 'index']);

Route::get('/student/create', [StudentController::class, 'create']);
Route::post('/student/create', [StudentController::class, 'store'])->name('student.create');

/**
 * TODO: Rutas para Representative ;)
 */

Route::get('/representative/show/idcard/{id}', [RepresentativeController::class, 'findByIdcard'])->name('representative.show');


/**
 * TODO: Rutas para Enrollment
 */

Route::get('/enrollment/index', [EnrollmentController::class, 'index']);

Route::get('/enrollment/create', [EnrollmentController::class, 'create']);
Route::post('/enrollment/create', [EnrollmentController::class, 'store'])->name('enrollment.create');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
