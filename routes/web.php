<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeRequestController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TimeLogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('schedules', ScheduleController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
    Route::resource('timelog', TimeLogController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
    Route::resource('checklists', ChecklistController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
    Route::resource('medicines', MedicineController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('inventory', InventoryController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
    Route::resource('pharmacies', PharmacyController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
    Route::resource('employees', EmployeeController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
    Route::resource('requests', EmployeeRequestController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
    Route::resource('reports', ReportController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
    Route::resource('exchange', ExchangeController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
    Route::resource('settings', SettingController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
    Route::resource('users', UserController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
});
