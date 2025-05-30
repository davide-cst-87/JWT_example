<?php

use App\Http\Controllers\AdminScanController;
use App\Http\Controllers\API\AdminTimeOffRequestController;
use App\Http\Controllers\API\AdminUserController;
use App\Http\Controllers\API\TimeOffRequestController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Route;

// TESTING
Route::get('/test', function () {
    return response()->json(['message' => 'Hello API']);
});

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    // User Controller
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/user', [UserController::class, 'update']);

    // Admin Controller
    Route::apiResource('users', AdminUserController::class);
    Route::patch('users/{id}/block', [AdminUserController::class, 'block']);
    Route::patch('users/{id}/unblock', [AdminUserController::class, 'unblock']);
    // The restore endpoint is used to recover an user that was deleted
    Route::patch('/users/{id}/restore', [AdminUserController::class, 'restore']);

    // User Scan Controller
    Route::get('/user/my-scan', [ScanController::class, 'index']);
    Route::get('/user/my-scan/{id}', [ScanController::class, 'show']);

    // Admin Scan Controller
    Route::apiResource('admin/scans', AdminScanController::class);

    // User Time Off Controller
    Route::apiResource('user/timeOff', TimeOffRequestController::class);

    Route::apiResource('admin/timeOff', AdminTimeOffRequestController::class);

});
// TODO Add the token check
// User Time Off Controller
// Route::apiResource('user/timeOff', TimeOffRequestController::class);

// TODO Implement the role admin to have a better security
// Route::middleware(['auth:api', 'role:admin'])->prefix('admin')->group(function () {
//     Route::apiResource('users', AdminUserController::class);
// });

// 🔹 Invitation-based registration (for invited users)
Route::post('/auth/register-from-invitation', [AuthController::class, 'registerFromInvitation']);

// 🔹 Send invitation (only for company-admins)
// Route::post('/invite', [InviteController::class, 'sendInvitation']);
Route::middleware(['auth:api'])->post('/invite', [InviteController::class, 'sendInvitation']);

// 🔹 Check if an invitation is valid
Route::get('/invited/{token}', [InviteController::class, 'checkInvitation']);

// HTTP Request from NodeMCU
Route::post('/log-scan', [ScanController::class, 'store']);
