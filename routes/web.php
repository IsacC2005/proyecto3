<?php

use App\Constants\RoleConstants;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DailyClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentGeneratorController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\JapecoSyncController;
use App\Http\Controllers\LearningProjectController;
use App\Http\Controllers\QualitieController;
use App\Http\Controllers\SettingIAController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Services\TicketServices;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\BackupController;
use App\Http\Middleware\EnsureProjectBelongsToTeacher;

Route::prefix('backups')->group(function () {
    Route::get('/', [BackupController::class, 'index'])->middleware(['auth', 'verified'])->name('backups.index');
    Route::post('/', [BackupController::class, 'store'])->middleware(['auth', 'verified'])->name('backups.store');
    Route::delete('/', [BackupController::class, 'destroy'])->middleware(['auth', 'verified'])->name('backups.destroy');
});

Route::get('/', WelcomeController::class)->name('home');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/user/index', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('manager.user.index');

Route::get('/user/create', [UserController::class, 'create'])->middleware(['auth', 'verified'])->name('manager.user.create');

Route::post('/user/create', [UserController::class, 'store'])->middleware(['auth', 'verified'])->name('user.create');

/**
 * TODO: Rutas para Teachers
 */

Route::get('/teacher/index', [TeacherController::class, 'index'])->middleware(['auth', 'verified'])->name('teacher.index');

Route::get('/teacher/create-user/{id}', [TeacherController::class, 'createUser'])->middleware(['auth', 'verified']);
Route::post('/teacher/create-user', [TeacherController::class, 'storeUser'])->middleware(['auth', 'verified'])->name('teacher.create-user');

Route::get('/teacher/edit/{id}', [TeacherController::class, 'edit'])->middleware(['auth', 'verified']);
Route::put('/teacher/update/{id}', [TeacherController::class, 'update'])->middleware(['auth', 'verified'])->name('teacher.update');

Route::get('teacher/enrollments-assigns', [TeacherController::class, 'enrollmentsAssigns'])->middleware(['auth', 'verified']);

Route::get('/teacher/evaluate', [TeacherController::class, 'evaluate'])->middleware(['auth', 'verified'])->name('teacher.evaluate');
Route::get('/teacher/evaluate/class', [TeacherController::class, 'listStudentsEvaluate'])->middleware(['auth', 'verified']);
Route::post('/teacher/evaluate/class/save', [TeacherController::class, 'evaluateStudent'])->middleware(['auth', 'verified'])->name('teacher.evaluateStudent');

/**
 * TODO: Rutasa para evaluar el ser del estudiante
 */

Route::get('/qualitie', [QualitieController::class, 'showPageEvaluate']);
Route::post('/qualitie/test', [QualitieController::class, 'store'])->name('qualitie.test');
Route::post('/quelitie/test/status', [QualitieController::class, 'storeStatus'])->name('qualitie.test.status');

/**
 * TODO: Rutas para Students
 */

Route::get('/student/index', [StudentController::class, 'index'])->middleware(['auth', 'verified']);

//Route::get('/student/create', [StudentController::class, 'create'])->middleware(['auth', 'verified'])->name('student.create');
//Route::post('/student/store', [StudentController::class, 'store'])->middleware(['auth', 'verified'])->name('student.store');

/**
 * TODO: Rutas para Representative ;)
 * ? Ya no se van a crear representantes dado que los estudiantes 
 * ? no se van a crear tampoco ya que se van a traer de japeco
 */
//Route::get('/representative/index', [RepresentativeController::class, 'index'])->name('representative.index');

//Route::get('/representative/show/idcard/{id}', [RepresentativeController::class, 'findByIdcard'])->middleware(['auth', 'verified'])->name('representative.show');


/**
 * TODO: Rutas para Enrollment
 */

Route::get('/enrollment/index', [EnrollmentController::class, 'index'])->middleware(['auth', 'verified']);
//Route::get('/enrollment/list/moment/{moment}', [EnrollmentController::class, 'findEnrollmentByYearSchool'])->middleware(['auth', 'verified']);

//Route::get('/enrollment/create', [EnrollmentController::class, 'create'])->middleware(['auth', 'verified']);
//Route::post('/enrollment/create', [EnrollmentController::class, 'store'])->middleware(['auth', 'verified'])->name('enrollment.create');
//Route::post('/enrollment/createLot', [EnrollmentController::class, 'storeLot'])->middleware(['auth', 'verified'])->name('enrollment.createLot');


//Route::get('/enrollment/edit/{id}', [EnrollmentController::class, 'edit'])->middleware(['auth', 'verified']);

//Route::get('/enrollment/assign-teacher/', [EnrollmentController::class, 'assignTeacher'])->middleware(['auth', 'verified']);
//Route::post('/enrollment/assign-teacher', [EnrollmentController::class, 'assignTeacherSave'])->middleware(['auth', 'verified'])->name('enrollment.assign-teacher');

//Route::get('/enrollment/add-student/', [EnrollmentController::class, 'addStudent'])->middleware(['auth', 'verified']);
//Route::post('/enrollment/add-student/', [EnrollmentController::class, 'addStudentSave'])->middleware(['auth', 'verified'])->name('enrollment.add-student');



















/*
*╔═══════════════════════════════════════•●•═══════════════════════════════════════╗
                    TODO: Rutas para LearningProject 𒆜𓊉꧂
*╚═══════════════════════════════════════•●•═══════════════════════════════════════╝
 */

Route::middleware([
    'auth',
    'role:' . RoleConstants::PROFESOR
])
    ->prefix('learning-project')
    ->group(function () {
        Route::get('/index', [LearningProjectController::class, 'index'])->name('learning-project.index');
        Route::get('/show/{id}', [LearningProjectController::class, 'show']);
        Route::get('/create', [LearningProjectController::class, 'create'])->name('learning-project.create');
        Route::post('/store', [LearningProjectController::class, 'store'])->name('learning-project.store');
        Route::get('/edit/{id}', [LearningProjectController::class, 'edit'])->name('learning-project.edit');
        Route::put('/update/{id}', [LearningProjectController::class, 'update'])->name('learning-project.update');
    });

Route::get('/learning-project/notes', [LearningProjectController::class, 'notes'])->middleware([
    'auth',
    'role:' . RoleConstants::PROFESOR . '||' . RoleConstants::ADMINISTRADOR,
    EnsureProjectBelongsToTeacher::class
])->name('learning-project.notes');















/*
*╔═══════════════════════════════════════•●•═══════════════════════════════════════╗
                    TODO: Rutas para DailyClass 𒆜𓊉꧂
*╚═══════════════════════════════════════•●•═══════════════════════════════════════╝
 */
Route::get('daily-class/create/{id?}', [DailyClassController::class, 'create'])->middleware(['auth', 'verified']);
Route::post('/daily-class/create', [DailyClassController::class, 'store'])->middleware(['auth', 'verified'])->name('daily-class.create');

Route::get('/daily-class/edit/{id}', [DailyClassController::class, 'edit'])->middleware(['auth', 'verified'])->name('learning-project.daily-class.edit');

Route::put('daily-class/update/{id}', [DailyClassController::class, 'update'])->middleware(['auth', 'verified']);



















/*
*╔═══════════════════════════════════════•●•═══════════════════════════════════════╗
                    TODO: Rutas para las boletas 𒆜𓊉꧂
*╚═══════════════════════════════════════•●•═══════════════════════════════════════╝
 */
Route::get('/tickets/index/{id?}', [TicketController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/tickets/create/{id?}', [TicketController::class, 'create'])->middleware(['auth', 'verified']);
Route::post('/tickets/storeLot/{id}', [TicketController::class, 'storeLot'])->middleware(['auth', 'verified']);

Route::get('/tickets/storeLot/progress/{jobId}', [TicketController::class, 'progressStoreLot'])->name('progress.status');
Route::get('/ticket/impress/{id}', [TicketController::class, 'impress']);



















/*
*╔═══════════════════════════════════════•●•═══════════════════════════════════════╗
                    TODO: Rutas para la configuracion de la IA 𒆜𓊉꧂
*╚═══════════════════════════════════════•●•═══════════════════════════════════════╝
 */
Route::get('/setting-ia', [SettingIAController::class, 'index']);
Route::post('/setting-ia', [SettingIAController::class, 'store']);













/**
 * 
 */

Route::get('/activity-log', [ActivityLogController::class, 'index']);

/**
 * TODO: Rutas para gestionar la sincronizacion con japeco
 */

Route::post('/japeco-test-conection', [JapecoSyncController::class, 'testContection']);

Route::get('/japeco-sync', [JapecoSyncController::class, 'JapecoSync']);
Route::post('/japeco-sync', [JapecoSyncController::class, 'JapecoSyncStart']);
Route::get('/japeco-sync/progress', [JapecoSyncController::class, 'JapecoSyncProgress']);

/**
 * TODO: Rutas de gestion de usuarios
 */


Route::get('/manager/users/edit/{id}', [UserController::class, 'AdminEditUser']);
Route::put('/manager/user/update/{id}', [UserController::class,  'AdminUpdateUser'])->name('manager.user.update');
Route::put('/manager/user/reset-password/{id}', [UserController::class,  'AdminResetPaswordUser'])->name('manager.user.reset-password');



/**
 * ? Ruta de prueba
 */

//Route::get('/test/evaluate/{id}', [EvaluationItemController::class, 'evaluateRandom']);
//Route::get('/test/evaluate-qualitie/{id}', [QualitieController::class, 'storeRandom']);
// Route::get('/test', [QualitieController::class, 'create']); 
// Route::post('/test', [QualitieController::class, 'store']);
// Route::post('/test/status', [QualitieController::class, 'storeStatus']);

Route::get('test', function () {
    $user = [
        'id' =>  10,
        'name' => 'isacc',
        'email' => 'isacc@isacc',
        'password' => null, // Aunque es null en el JSON, en la DB es string
        'role' => [],
        'roleId' => 1,
        'userable_id' => 9
    ];
    return Inertia::render('Users/UserEdit/UserEdit');
});

Route::get('/test2', function (TicketServices $servie) {
    $servie->create(5, 36405);

    return response()->json('que pasa crak');
});


Route::get('/test-docx', [DocumentGeneratorController::class, 'generateDocx']);

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
