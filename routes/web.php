<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [MainController::class, 'index'])->name('/');
Route::get('select-plan', [MainController::class, 'select_plan'])->name('select-plan');
Route::get('confirm-payment', [MainController::class, 'confirm_payment'])->name('confirm-payment');
Route::get('logout', [LoginController::class, 'logout']);
Auth::routes();
Route::get('home', [HostController::class, 'index'])->name('home');
Route::get('screen-recording', [HostController::class, 'screen_record'])->name('screen_recording');
