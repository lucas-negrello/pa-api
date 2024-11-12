<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentPermissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\GoalPermissionController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\ShoppingListItemController;
use App\Http\Controllers\ShoppingListPermissionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskPermissionController;
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
        // RESOURCE ROUTES
        Route::resource('/appointments', AppointmentController::class)->parameter('','appointment');
        Route::resource('/goals', GoalController::class)->parameter('','goal');
        Route::resource('/shoppingLists', ShoppingListController::class)->parameter('','shoppingList');
        Route::resource('/shoppingListItems', ShoppingListItemController::class)->parameter('','shoppingListItem');
        Route::resource('/tasks', TaskController::class)->parameter('','task');
        // PERMISSION ROUTES
        Route::resource('/appointmentPermissions', AppointmentPermissionController::class);
        Route::resource('/goalPermissions', GoalPermissionController::class);
        Route::resource('/shoppingListPermissions', ShoppingListPermissionController::class);
        Route::resource('/taskPermissions', TaskPermissionController::class);
    });
});


