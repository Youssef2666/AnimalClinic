<?php

use App\Http\Controllers\AnimalCategoryController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//email
Route::post('send-email-verification', [AuthController::class, 'sendEmailVerification']);
Route::post('verify-email', [AuthController::class, 'verifyEmail']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('authme', [AuthController::class, 'authme']);
    Route::delete('logout', [AuthController::class, 'logout']);
    Route::apiResources(
        [
            'animals' => AnimalController::class,
            'animals_category' => AnimalCategoryController::class,
            'doctors' => DoctorController::class,
        ]
    );
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('check', function () {
        return 'yes I am Admin';
    });
    Route::get('users', [AuthController::class, 'index']);
});

Route::fallback(function () {
    return response()->json(['message' => 'Page Not Found.'], 404);
});