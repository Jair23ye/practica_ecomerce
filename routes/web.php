<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS — accesibles para todos (anónimos y autenticados)
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('pages.home'))->name('home');
Route::get('/quienes-somos', fn () => view('pages.about'))->name('about');
Route::get('/contacto', fn () => view('pages.contact'))->name('contact');
Route::get('/mision-vision', fn () => view('pages.mission'))->name('mission');
Route::get('/ubicacion', fn () => view('pages.location'))->name('location');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);

    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARDS (protegidos por autenticación y rol)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/dashboard/cliente', [DashboardController::class, 'cliente'])
         ->name('dashboard.cliente');
});

Route::middleware(['auth', 'role:empleado'])->group(function () {
    Route::get('/dashboard/empleado', [DashboardController::class, 'empleado'])
         ->name('dashboard.empleado');
});

Route::middleware(['auth', 'role:gerente'])->group(function () {
    Route::get('/dashboard/gerente', [DashboardController::class, 'gerente'])
         ->name('dashboard.gerente');

         // Dentro de tu grupo de Gerente
Route::middleware(['auth', 'role:gerente'])->group(function () {
    Route::get('/dashboard/gerente', [DashboardController::class, 'gerente'])->name('dashboard.gerente');
    
    // Esta línea crea automáticamente las rutas index, show, update y destroy
    Route::apiResource('usuarios', UserController::class);
});
});
