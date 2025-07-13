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
    Route::get('/admin/dashboard', fn() => Inertia::render('Admin/Dashboard'))->middleware('admin')->name('admin.dashboard');
    Route::get('/admin/users', fn() => Inertia::render('Admin/Users'))->middleware('admin')->name('admin.users');
    Route::get('/admin/tasks', fn() => Inertia::render('Admin/Tasks'))->middleware('admin')->name('admin.tasks');
    Route::get('/user/tasks', fn() => Inertia::render('User/Tasks'))->name('user.tasks');
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
