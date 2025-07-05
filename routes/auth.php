<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')
        ->name('login');

    Volt::route('register', 'auth.register')
        ->name('register');

    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'auth.reset-password')
        ->name('password.reset');
});





Route::middleware('auth')->group(function () {

    Volt::route('verify-email', 'auth.verify-email')
    ->name('verification.notice');

    Volt::route('confirm-password', 'auth.confirm-password')
        ->name('password.confirm');
});

Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
->middleware(['signed', 'throttle:6,1','UserOrAdmin'])
->name('verification.verify');


Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');


// Admin Routes

Route::prefix('admin')->group(function () {

    Route::middleware('auth:admin')->group(function () {

        Route::view('verify-email', 'admin.verify-email')
        ->name('admin.verification.notice');

        // Volt::route('verify-email', 'admin.verify-email')
        //     ->name('admin.verification.notice');
    
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('admin.verification.verify');
    
        Volt::route('confirm-password', 'auth.confirm-password')
            ->name('admin.password.confirm');
    });
    
    Route::view('login', 'admin.login')
        ->name('admin.login');

    Route::view('register', 'admin.register')
        ->name('admin.register');

    Route::view('forgot-password', 'admin.forgot-password')
        ->name('admin.password.request');

    Route::view('reset-password/{token}/{email}', 'admin.reset-password')
        ->name('admin.password.reset');

    Route::view('dashboard', 'admin.dashboard')
        ->middleware(['auth:admin','adminVerified'])
        ->name('admin.dashboard');
});
