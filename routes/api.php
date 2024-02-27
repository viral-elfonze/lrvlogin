<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(LoginRegisterController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::get('/login/microsoft', [App\Http\Controllers\AuthController::class, 'redirectToMicrosoft'])->name('microsoft.login');
Route::get('/login/microsoft/callback', [App\Http\Controllers\AuthController::class, 'handleMicrosoftCallback'])->name('microsoft.handleMicrosoftCallback');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/user1', function (Request $request) {
    return "asd";
});

// Authentication
// Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return response()->json(['message' => 'Welcome Admin!']);
    });

    // Route::resource('users', UserController::class);
    // Route::resource('roles', RoleController::class);
    // Route::resource('permissions', PermissionController::class);
});


Route::get('/admin', function () {
    // Only users with the 'admin' role can access this route
})->middleware('role:admin');

Route::get('/manage-teams', function () {
    // Only users with the 'team manager' role can access this route
})->middleware('role:team manager');

Route::get('/edit-profile', function () {
    // Only users with the 'user' role and the permission 'edit-profile' can access this route
})->middleware('role:user', 'permission:edit-profile');
