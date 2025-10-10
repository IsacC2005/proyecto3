<?php

use App\DTOs\UserDTO;
use App\Http\Controllers\DailyClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LearningProjectController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\SettingIAController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Jobs\testJob;
use App\Models\User;
use App\Repositories\AIRepositori;
use App\Repositories\LearningProjectRepository;
use App\services\UserServices;
use Illuminate\Support\Facades\Http;
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

Route::get('/teacher/index', [TeacherController::class, 'index'])->middleware(['auth', 'verified'])->name('teacher.index');

Route::get('/teacher/create-user/{id}', [TeacherController::class, 'create'])->middleware(['auth', 'verified']);
Route::post('/teacher/create-user', [TeacherController::class, 'storeUser'])->middleware(['auth', 'verified'])->name('teacher.create-user');

Route::get('/teacher/edit', [TeacherController::class, 'edit'])->middleware(['auth', 'verified']);
Route::put('/teacher/update/{id}', [TeacherController::class, 'update'])->middleware(['auth', 'verified'])->name('teacher.update');

Route::get('teacher/enrollments-assigns', [TeacherController::class, 'enrollmentsAssigns'])->middleware(['auth', 'verified']);

Route::get('/teacher/evaluate', [TeacherController::class, 'evaluate'])->middleware(['auth', 'verified'])->name('teacher.evaluate');
Route::get('/teacher/evaluate/class', [TeacherController::class, 'listStudentsEvaluate'])->middleware(['auth', 'verified']);
Route::post('/teacher/evaluate/class/save', [TeacherController::class, 'evaluateStudent'])->middleware(['auth', 'verified'])->name('teacher.evaluateStudent');
/**
 * TODO: Rutas para Students
 */

Route::get('/student/index', [StudentController::class, 'index'])->middleware(['auth', 'verified']);

Route::get('/student/create', [StudentController::class, 'create'])->middleware(['auth', 'verified'])->name('student.create');
Route::post('/student/store', [StudentController::class, 'store'])->middleware(['auth', 'verified'])->name('student.store');

/**
 * TODO: Rutas para Representative ;)
 */
Route::get('/representative/index', [RepresentativeController::class, 'index'])->name('representative.index');

Route::get('/representative/show/idcard/{id}', [RepresentativeController::class, 'findByIdcard'])->middleware(['auth', 'verified'])->name('representative.show');


/**
 * TODO: Rutas para Enrollment
 */

Route::get('/enrollment/index', [EnrollmentController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/enrollment/list/moment/{moment}', [EnrollmentController::class, 'findEnrollmentByYearSchool'])->middleware(['auth', 'verified']);

Route::get('/enrollment/create', [EnrollmentController::class, 'create'])->middleware(['auth', 'verified']);
Route::post('/enrollment/create', [EnrollmentController::class, 'store'])->middleware(['auth', 'verified'])->name('enrollment.create');
Route::post('/enrollment/createLot', [EnrollmentController::class, 'storeLot'])->middleware(['auth', 'verified'])->name('enrollment.createLot');


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

/**
 * TODO: Rutas para las boletas
 */
Route::get('/tickets', [TicketController::class, 'index'])->middleware(['auth', 'verified']);

Route::get('/tickets/create', [TicketController::class, 'create'])->middleware(['auth', 'verified']);
Route::post('/tickets/storeLot/{id}', [TicketController::class, 'storeLot'])->middleware(['auth', 'verified']);

Route::get('/tickets/storeLot/progress/{jobId}', [TicketController::class, 'progressStoreLot'])->name('progress.status');

/**
 * TODO: Rutas para la configuracion de la IA
 */
Route::get('/setting-ia', [SettingIAController::class, 'index']);
Route::post('/setting-ia', [SettingIAController::class, 'store']);



Route::get('test', function () {
    $response = Http::get('http://localhost:4000/api/teacher/index');
    //return "hola";

    if ($response->successful()) {
        $data = $response->json();

        return response()->json([
            'data' => $data
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Fallo al conectar con la API o error del servidor.',
            'status_code' => $response->status()
        ], $response->status());
    }
    return "error en algo";
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
