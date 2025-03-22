<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InviteController;

use App\Http\Controllers\API\UserController;

use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;


// TESTING 
Route::get('/test', function () {
    return response()->json(['message' => 'Hello API']);
});


Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class,'login'])->name('login');
    Route::post('register', [AuthController::class,'register']);

});
Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
    Route::get('/user', [UserController::class, 'show']);
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
    Mail::to('castelli1987.dc@gmail.com')->send(new TestEmail());
    return 'Test email sent!';
});