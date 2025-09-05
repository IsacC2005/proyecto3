<?php

use App\DTOs\UserDTO;
use App\Http\Controllers\DailyClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LearningProjectController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\User;
use App\Repositories\AIRepositori;
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

Route::get('/teacher/edit', [TeacherController::class, 'edit']);
Route::get('/teacher/update/{id}', [TeacherController::class, 'update'])->name('teacher.update');

Route::get('teacher/enrollments-assigns', [TeacherController::class, 'enrollmentsAssigns']);

Route::get('/teacher/evaluate', [TeacherController::class, 'evaluate']);
Route::get('/teacher/evaluate/class', [TeacherController::class, 'listStudentsEvaluate']);
Route::post('/teacher/evaluate/class/save', [TeacherController::class, 'evaluateStudent'])->name('teacher.evaluateStudent');
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
Route::get('/enrollment/list/moment/{moment}', [EnrollmentController::class, 'findEnrollmentByYearSchool']);

Route::get('/enrollment/create', [EnrollmentController::class, 'create']);
Route::post('/enrollment/create', [EnrollmentController::class, 'store'])->name('enrollment.create');

Route::get('/enrollment/edit/{id}', [EnrollmentController::class, 'edit']);

Route::get('/enrollment/assign-teacher/', [EnrollmentController::class, 'assignTeacher']);
Route::post('/enrollment/assign-teacher', [EnrollmentController::class, 'assignTeacherSave'])->name('enrollment.assign-teacher');

Route::get('/enrollment/add-student/', [EnrollmentController::class, 'addStudent']);
Route::post('/enrollment/add-student/', [EnrollmentController::class, 'addStudentSave'])->name('enrollment.add-student');

/**
 * TODO: Rutas para LearningProject ;-)
 */

Route::get('/learning-project/index', [LearningProjectController::class, 'index']);

Route::get('/learning-project/show/{id}', [LearningProjectController::class, 'show']);

Route::get('/learning-project/create', [LearningProjectController::class, 'create']);
Route::post('/learning-project/create', [LearningProjectController::class, 'store'])->name('learning-project.create');

Route::get('/learning-project/edit/{id}', [LearningProjectController::class, 'edit']);
Route::put('/learning-project/update/{id}', [LearningProjectController::class, 'update'])->name('learning-project.update');


/**
 * TODO: Rutas para DailyClass
 */
Route::get('daily-class/create', [LearningProjectController::class, 'createClass']);
Route::post('/daily-class/create', [DailyClassController::class, 'store'])->name('daily-class.create');

Route::get('/daily-class/edit/{id}', [DailyClassController::class, 'edit'])->name('learning-project.daily-class.edit');

Route::put('daily-class/update/{id}', [DailyClassController::class, 'update']);

Route::get('/test', function () {
    return AIRepositori::test();
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
