<?php

use App\DTOs\UserDTO;
use App\Http\Controllers\DashboardController;
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




require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
