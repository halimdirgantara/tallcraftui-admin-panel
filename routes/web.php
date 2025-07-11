<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    
    // Password Reset Routes
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
    
    Route::post('/forgot-password', function () {
        // Handle password reset email
        return redirect()->back()->with('success', 'Password reset link sent to your email');
    })->name('password.email');
    
    Route::get('/reset-password/{token}', function ($token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');
    
    Route::post('/reset-password', function () {
        // Handle password reset
        return redirect()->route('login')->with('success', 'Password reset successfully');
    })->name('password.update');
});

// Admin Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::get('/users', function () {
        return view('admin.users');
    })->name('users');
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    
    Route::put('/profile', function () {
        // Handle profile update
        return redirect()->back()->with('success', 'Profile updated successfully');
    })->name('profile.update');
    
    Route::put('/password', function () {
        // Handle password update
        return redirect()->back()->with('success', 'Password updated successfully');
    })->name('password.update');
    
    // Test route to check if the issue is with the profile route
    Route::get('/test-profile', function () {
        return view('test-profile');
    })->name('test.profile');
});

// Logout Route
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');
