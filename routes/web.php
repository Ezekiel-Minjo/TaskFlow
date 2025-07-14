<?php
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', fn() => Inertia::render('Welcome'))->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', fn() => Inertia::render('Admin/Dashboard'))->name('admin.dashboard');
        
        // User management routes
        Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users');
        Route::post('/admin/users', [App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');
        
        // Task management routes
        Route::get('/admin/tasks', [App\Http\Controllers\TaskController::class, 'adminIndex'])->name('admin.tasks');
        Route::post('/admin/tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('admin.tasks.store');
        Route::put('/admin/tasks/{task}', [App\Http\Controllers\TaskController::class, 'update'])->name('admin.tasks.update');
        Route::delete('/admin/tasks/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('admin.tasks.destroy');
    });
    
    // User routes
    Route::get('/user/tasks', [App\Http\Controllers\TaskController::class, 'userIndex'])->name('user.tasks');
    Route::put('/user/tasks/{task}/status', [App\Http\Controllers\TaskController::class, 'updateStatus'])->name('user.tasks.updateStatus');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-email', function () {
    $task = \App\Models\Task::create([
        'title' => 'Test Task',
        'user_id' => 1,
        'deadline' => '2025-07-15',
    ]);
    \Illuminate\Support\Facades\Mail::to('test@example.com')->send(new \App\Mail\TaskAssigned($task));
    return 'Email sent!';
});

require __DIR__.'/auth.php';
