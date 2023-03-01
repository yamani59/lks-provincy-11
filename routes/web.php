<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\ArticleController;

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

Route::middleware('auth')->group(function() {
    Route::prefix('dashboard')->group(function() {
        Route::middleware('role:writer')->group(function() {
            Route::get('/', fn() => view('admin.dashbaord'));
        });
        Route::get('/article', [ArticleController::class, 'adminIndex']);
        Route::get('/article/create', [ArticleController::class, 'create']);
        Route::get('/article/{slug}/edit', [ArticleController::class, 'edit']);
        Route::get('/categor', fn() => view('admin.category.index'));
        Route::get('/category/create', fn() => view('admin.category.form'));
        Route::get('/category/{slug}/edit', fn() => view('admin.category.form'));
        Route::get('/command', fn() => view('admin.command.index'));
    });

    Route::prefix('article')->group(function() {
        Route::post('/', [ArticleController::class, 'store']);
        Route::patch('/{slug}', [ArticleController::class, 'update']);
    });
    Route::get('/{any}', fn() => redirect('/dashboaard'));
});