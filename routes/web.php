<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function() {
    Route::post('/logout', [AuthenticateController::class, 'logout']);
    Route::middleware('guest')->group(function() {
        Route::get('/login', [AuthenticateController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthenticateController::class, 'login']);
        Route::get('/register', [AuthenticateController::class, 'showRegister']);
        Route::post('/register', [AuthenticateController::class, 'register']);
    });
});

Route::prefix('dashboard')->middleware('auth')->group(function() {
    Route::get('/', fn() => view('admin.dashbaord'));
    Route::get('/article', fn() => view('admin.article'));
});

Route::any('{query}', fn() => redirect('/auth/login'));