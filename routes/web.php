<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login/microsoft', [App\Http\Controllers\AuthController::class, 'redirectToMicrosoft'])->name('microsoft.login');
Route::get('/login/microsoft/callback', [App\Http\Controllers\AuthController::class, 'handleMicrosoftCallback'])->name('microsoft.handleMicrosoftCallback');

// Route::get('/login/microsoft', 'AuthController@redirectToMicrosoft')->name('microsoft.login');
// Route::get('/login/microsoft/callback', 'AuthController@handleMicrosoftCallback');
