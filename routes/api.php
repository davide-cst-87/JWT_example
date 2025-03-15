<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InviteController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);

});
Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});

Route::get('/test', function () {
    return response()->json(['message' => 'Hello API']);
});
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;

Route::get('/send-test-email', function () {
    Mail::to('castelli1987.dc@gmail.com')->send(new TestEmail());
    return 'Test email sent!';
});





// 🔹 Invitation-based registration (for invited users)
Route::post('/auth/register-from-invitation', [AuthController::class, 'registerFromInvitation']);

// 🔹 Send invitation (only for company-admins)
// Route::post('/invite', [InviteController::class, 'sendInvitation']);
Route::middleware(['auth:api'])->post('/invite', [InviteController::class, 'sendInvitation']);

// 🔹 Check if an invitation is valid
Route::get('/invited/{token}', [InviteController::class, 'checkInvitation']);