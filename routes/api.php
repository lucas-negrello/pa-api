<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\VerificationController;
use App\Http\Middleware\LogLoginAttempts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// V1 API Routes
Route::prefix('v1')->group(function () {

// REGISTER ROUTES
    Route::post('/register', [AuthController::class, 'register']);

// EMAIL VERIFICATION ROUTES
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend']);

// LOGIN-LOGOUT ROUTES
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware(['throttle:login', LogLoginAttempts::class]);
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');

// PASSWORD RESEND ROUTES
    Route::post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');

// ROUTES FOR VERIFIED EMAILS USERS
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

// ROUTES FOR AUTHENTICATED/LOGGED IN USERS
    Route::middleware('auth:sanctum')->group(function () {

    });
});


