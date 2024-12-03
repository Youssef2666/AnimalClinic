<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\LocalBankCardsController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    'role:admin',
])->group(function () {
    Route::get('check', function () {
        return 'yes I am Admin';
    });
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
});

Route::get('/payment/success', function () {
    return view('payment.success');
})->name('payment.success');

Route::get('/payment/failure', function () {
    return view('payment.failure');
})->name('payment.failure');

Route::get('/payment/callback', [LocalBankCardsController::class, 'handleCallback'])->name('payment.callback')->middleware('auth:sanctum');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');