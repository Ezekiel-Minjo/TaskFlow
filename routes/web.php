<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;

Route::get('/', fn() => Inertia::render('Welcome'))->name('welcome');

Route::get('/dashboard', fn() => Inertia::render('Dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', fn() => Inertia::render('Admin/Dashboard'))->middleware('admin')->name('admin.dashboard');
    Route::get('/admin/users', fn() => Inertia::render('Admin/Users'))->middleware('admin')->name('admin.users');
    Route::get('/admin/tasks', fn() => Inertia::render('Admin/Tasks'))->middleware('admin')->name('admin.tasks');
    Route::get('/user/tasks', fn() => Inertia::render('User/Tasks'))->name('user.tasks');

    // ✅ Added profile routes to fix Ziggy error
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

require __DIR__.'/auth.php';
