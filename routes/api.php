<?php


use App\Http\Controllers\API\AdminUserController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InviteController;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ScanController;
use Illuminate\Http\Request;

use App\Mail\TestEmail;

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
});

// TODO
// Route::middleware(['auth:api', 'role:admin'])->prefix('admin')->group(function () {
//     Route::apiResource('users', AdminUserController::class);
// });




Route::post('/log-scan', [ScanController::class, 'store']);


Route::get('/send-test-email', function () {
    Mail::to('castelli1987.dc@gmail.com')->send(new TestEmail);
    return 'Test email sent!';
});


// 🔹 Invitation-based registration (for invited users)
Route::post('/auth/register-from-invitation', [AuthController::class, 'registerFromInvitation']);

// 🔹 Send invitation (only for company-admins)
// Route::post('/invite', [InviteController::class, 'sendInvitation']);
Route::middleware(['auth:api'])->post('/invite', [InviteController::class, 'sendInvitation']);

// 🔹 Check if an invitation is valid
Route::get('/invited/{token}', [InviteController::class, 'checkInvitation']);


// BELOW should be a test Remove as soon as possible
Route::get('/send-test-email', function () {
    Mail::to('castelli1987.dc@gmail.com')->send(new TestEmail);
    return 'Test email sent!';
});

