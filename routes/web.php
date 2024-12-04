<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Auth
Route::middleware(['auth'])->group(function () {
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
    Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Guests
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'register'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'store'])->name('auth.store');
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('auth.authenticate');
});
