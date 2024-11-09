<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ForecastController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/estimate', [HomeController::class, 'estimate'])
    ->name('estimate');
    
Route::get('/forecast', [ForecastController::class, 'predict']);

Route::post('/message', [HomeController::class, 'message'])
    ->name('sendMessage');

Route::any('/logout', [LoginController::class, 'logout']);

Auth::routes();