<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskGroupController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Tasks
    Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Groups
    Route::post('/groups', [TaskGroupController::class, 'store'])->name('groups.store');
    Route::delete('/groups/{group}', [TaskGroupController::class, 'destroy'])->name('groups.destroy');

    // Statistics
    Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics');

    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze redirects here after login, so keep this route
Route::get('/dashboard', fn () => redirect()->route('tasks.index'))
    ->middleware('auth')
    ->name('dashboard');

require __DIR__.'/auth.php';