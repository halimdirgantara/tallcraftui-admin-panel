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

// Logout Route
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');
