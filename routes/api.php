<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeDetailsController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\EmployeeSkillMatrixController;

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

Route::controller(LoginRegisterController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::get('/login/microsoft', [App\Http\Controllers\AuthController::class, 'redirectToMicrosoft'])->name('microsoft.login');
Route::get('/login/microsoft1', [App\Http\Controllers\AuthController::class, 'redirectToMicrosoft1'])->name('microsoft.login1');
Route::get('/login/microsoft/callback', [App\Http\Controllers\AuthController::class, 'handleMicrosoftCallback'])->name('microsoft.handleMicrosoftCallback');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return ($request->user())?"auth":"unauth";
});
Route::middleware('auth:sanctum')->get('/user1', function (Request $request) {
    return "asd";
});








Route::middleware('auth')->group(function () {
    Route::post('/userdetails', [UserController::class, 'logout'])->name('user.lougout');
});
Route::middleware('auth:sanctum')->group(function () {

});

Route::middleware('cors')->group(function () {
    Route::get('/locations', [EmployeeDetailsController::class, 'getLocations'])->name('locations.list');

    Route::post('/user/logout', [UserController::class, 'logout'])->name('user.lougout');
    Route::post('/user/list', [UserController::class, 'list'])->name('user.list');
    Route::post('/user/uploadimage', [UserController::class, 'uploadImage'])->name('user.uploadImage');
    Route::get('/user/getimage', [UserController::class, 'getImage'])->name('user.getImage');

    Route::get('verify-employee/{employee_id}', [EmployeeDetailsController::class, 'verifyemployee_id'])->name('employee.verify.id');
    Route::get('verify-employee-code/{employee_code}', [EmployeeDetailsController::class, 'verifyemployee_code'])->name('employee.verify.code');
    Route::get('/employee/list', [EmployeeDetailsController::class, 'getEmployeeDetails'])->name('employee.list');
    Route::post('/employee/store', [EmployeeDetailsController::class, 'saveEmployeeDetail'])->name('employee.store');
    Route::get('/employee/show/{employee_id}', [EmployeeDetailsController::class, 'showEmployeeDetail'])->name('employee.show');
    Route::post('/employee/update/{employee_id}', [EmployeeDetailsController::class, 'updateEmployeeDetail'])->name('employee.update');
    Route::delete('/employee/delete/{employee_id}', [EmployeeDetailsController::class, 'removeEmployeeDetail'])->name('employee.delete');

    Route::get('/employee/skills', [EmployeeDetailsController::class, 'getEmployeeSkills'])->name('employee.skills');


    Route::get('/skills', [EmployeeSkillMatrixController::class, 'getAllSkills'])->name('skills.list');

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
