<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::get('/', [HomeController::class, 'index'])->name('home.index');
