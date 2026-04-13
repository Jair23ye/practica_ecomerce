<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
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
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/registro',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARDS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard/cliente', [DashboardController::class, 'cliente'])
         ->name('dashboard.cliente');

    Route::get('/dashboard/gerente', [DashboardController::class, 'gerente'])
         ->name('dashboard.gerente');

    Route::get('/dashboard/administrador', [DashboardController::class, 'administrador'])
         ->name('dashboard.administrador');

    /*
    |--------------------------------------------------------------------------
    | CRUD RECURSOS
    |--------------------------------------------------------------------------
    */
    Route::resource('productos',  ProductoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('ventas',     VentaController::class);
    Route::resource('usuarios',   UsuarioController::class);
});