<?php

use App\Http\Controllers\AnimalCategoryController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SurgeryCategoryController;
use App\Http\Controllers\SurgeryController;
use App\Http\Controllers\ZoomController;
use App\Models\User;
use function Pest\Laravel\json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/test',function(){
    return "GOOOOOOOOOOOO";
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/forgot-password', [PasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [PasswordController::class, 'resetPassword']);



// Routes for authenticated users
Route::middleware(['auth:sanctum', 'status'])->group(function () {
    Route::get('authme', [AuthController::class, 'authme']);
    Route::delete('logout', [AuthController::class, 'logout']);
    Route::apiResources([
        'animals' => AnimalController::class,
        'animals_category' => AnimalCategoryController::class,
        'doctors' => DoctorController::class,
        'surgery' => SurgeryController::class,
        'surgeries_category' => SurgeryCategoryController::class,
    ]);
});

// Routes for admin users
Route::middleware(['auth:sanctum', 'role:admin', 'status'])->group(function () {
    Route::get('check', function () {
        return 'Yes, I am Admin';
    });
    Route::get('users', [AuthController::class, 'index']);
});

// Fallback route for handling 404 errors
Route::fallback(function () {
    return response()->json(['message' => 'Page Not Found.'], 404);
});

// Public route for ZoomController
Route::get('zoom', [ZoomController::class, 'index']);