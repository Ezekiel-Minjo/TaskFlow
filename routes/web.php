<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssigned;

Route::get('/', fn() => Inertia::render('Welcome'))->name('welcome');

Route::get('/dashboard', fn() => Inertia::render('Dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', fn() => Inertia::render('Admin/Dashboard'))->middleware('admin')->name('admin.dashboard');
    Route::get('/admin/users', fn() => Inertia::render('Admin/Users'))->middleware('admin')->name('admin.users');
    Route::get('/admin/tasks', fn() => Inertia::render('Admin/Tasks'))->middleware('admin')->name('admin.tasks');
    Route::get('/user/tasks', fn() => Inertia::render('User/Tasks'))->name('user.tasks');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
->middleware('guest')
->name('login');
require __DIR__.'/auth.php';

Route::get('/test-email', function () {
    $user = User::find(1); // Or use factory/seed data

    if (!$user) {
        return response('User not found', 404);
    }

    $task = Task::create([
        'title' => 'Test Task',
        'description' => 'This is a test task.',
        'deadline' => now()->addDays(3)->format('Y-m-d'),
        'user_id' => $user->id
    ]);

    // Verify task creation
    if (!$task) {
        return response('Failed to create task', 500);
    }

    // Send email with error handling
    try {
        Mail::to($user->email)->send(new TaskAssigned($task));
        return 'Test email sent successfully!';
    } catch (\Exception $e) {
        return response('Failed to send email: '.$e->getMessage(), 500);
    }
});
