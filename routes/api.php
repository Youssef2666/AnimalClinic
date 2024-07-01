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

Route::get('users', [AuthController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('authme', [AuthController::class, 'authme']);
    Route::apiResources(
        [
            'animals' => AnimalController::class,
            'animals_category' => AnimalCategoryController::class,
            'doctors' => DoctorController::class,
        ]
    );

});
