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

Route::get('create-user', [UserController::class, 'show'])->middleware(['auth', 'verified'])->name('user.show');

Route::post('create-user', [UserController::class, 'create'])->middleware(['auth', 'verified'])->name('user.create');

/**
 * TODO: Rutas para Teachers
 */

Route::get('/teacher/index', [TeacherController::class, 'index'])->middleware(['auth', 'verified']);

Route::get('/teacher/create', [TeacherController::class, 'create'])->middleware(['auth', 'verified']);
Route::post('/teacher/create', [TeacherController::class, 'store'])->middleware(['auth', 'verified'])->name('teacher.create');

Route::get('/teacher/edit', [TeacherController::class, 'edit'])->middleware(['auth', 'verified']);
Route::get('/teacher/update/{id}', [TeacherController::class, 'update'])->middleware(['auth', 'verified'])->name('teacher.update');

Route::get('teacher/enrollments-assigns', [TeacherController::class, 'enrollmentsAssigns'])->middleware(['auth', 'verified']);

Route::get('/teacher/evaluate', [TeacherController::class, 'evaluate'])->middleware(['auth', 'verified'])->name('teacher.evaluate');
Route::get('/teacher/evaluate/class', [TeacherController::class, 'listStudentsEvaluate'])->middleware(['auth', 'verified']);
Route::post('/teacher/evaluate/class/save', [TeacherController::class, 'evaluateStudent'])->middleware(['auth', 'verified'])->name('teacher.evaluateStudent');
/**
 * TODO: Rutas para Students
 */

Route::get('/student/index', [StudentController::class, 'index'])->middleware(['auth', 'verified']);

Route::get('/student/create', [StudentController::class, 'create'])->middleware(['auth', 'verified']);
Route::post('/student/create', [StudentController::class, 'store'])->middleware(['auth', 'verified'])->name('student.create');

/**
 * TODO: Rutas para Representative ;)
 */

Route::get('/representative/show/idcard/{id}', [RepresentativeController::class, 'findByIdcard'])->middleware(['auth', 'verified'])->name('representative.show');


/**
 * TODO: Rutas para Enrollment
 */

Route::get('/enrollment/index', [EnrollmentController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/enrollment/list/moment/{moment}', [EnrollmentController::class, 'findEnrollmentByYearSchool'])->middleware(['auth', 'verified']);

Route::get('/enrollment/create', [EnrollmentController::class, 'create'])->middleware(['auth', 'verified']);
Route::post('/enrollment/create', [EnrollmentController::class, 'store'])->middleware(['auth', 'verified'])->name('enrollment.create');

Route::get('/enrollment/edit/{id}', [EnrollmentController::class, 'edit'])->middleware(['auth', 'verified']);

Route::get('/enrollment/assign-teacher/', [EnrollmentController::class, 'assignTeacher'])->middleware(['auth', 'verified']);
Route::post('/enrollment/assign-teacher', [EnrollmentController::class, 'assignTeacherSave'])->middleware(['auth', 'verified'])->name('enrollment.assign-teacher');

Route::get('/enrollment/add-student/', [EnrollmentController::class, 'addStudent'])->middleware(['auth', 'verified']);
Route::post('/enrollment/add-student/', [EnrollmentController::class, 'addStudentSave'])->middleware(['auth', 'verified'])->name('enrollment.add-student');

/**
 * TODO: Rutas para LearningProject ;-)
 */

Route::get('/learning-project/index', [LearningProjectController::class, 'index'])->middleware(['auth', 'verified'])->name('learning-project.index');

Route::get('/learning-project/show/{id}', [LearningProjectController::class, 'show'])->middleware(['auth', 'verified']);

Route::get('/learning-project/create', [LearningProjectController::class, 'create'])->middleware(['auth', 'verified']);
Route::post('/learning-project/create', [LearningProjectController::class, 'store'])->middleware(['auth', 'verified'])->name('learning-project.create');

Route::get('/learning-project/notes/{id?}', [LearningProjectController::class, 'notes'])->name('learning-project.notes');

Route::get('/learning-project/edit/{id}', [LearningProjectController::class, 'edit'])->middleware(['auth', 'verified']);
Route::put('/learning-project/update/{id}', [LearningProjectController::class, 'update'])->middleware(['auth', 'verified'])->name('learning-project.update');


/**
 * TODO: Rutas para DailyClass
 */
Route::get('daily-class/create', [DailyClassController::class, 'create'])->middleware(['auth', 'verified']);
Route::post('/daily-class/create', [DailyClassController::class, 'store'])->middleware(['auth', 'verified'])->name('daily-class.create');

Route::get('/daily-class/edit/{id}', [DailyClassController::class, 'edit'])->middleware(['auth', 'verified'])->name('learning-project.daily-class.edit');

Route::put('daily-class/update/{id}', [DailyClassController::class, 'update'])->middleware(['auth', 'verified']);

Route::get('/test', [TeacherController::class, 'statisticsNote']);

Route::post('/test', function () {

    // return redirect()->route('dashboard')->with('flash', [
    //     'alert' => [
    //         'title' => 'Prueba desde el back',
    //         'message' => 'Esta es una prueba de una acción exitosa.',
    //         'code' => '200'
    //     ]
    // ]);

    return redirect()->route('learning-project.index')->with('flash', [
        'alert' => [
            'title' => '¡Exito!',
            'message' => 'El proyecto de aprendizaje se creo correctamente :)',
            'code' => '200'
        ]
    ]);
    //return AIRepositori::test();
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
