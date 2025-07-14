<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Mail\TaskAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function adminIndex()
    {
        $tasks = Task::with('user')->orderBy('created_at', 'desc')->get();
        $users = User::where('role', 'user')->get();
        
        return Inertia::render('Admin/Tasks', [
            'tasks' => $tasks,
            'users' => $users
        ]);
    }

    public function userIndex()
    {
        $tasks = Task::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return Inertia::render('User/Tasks', [
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'deadline' => 'required|date|after:today',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'deadline' => $request->deadline,
            'status' => 'Pending',
        ]);

        // Send email notification to the assigned user
        $user = User::find($request->user_id);
        try {
            Mail::to($user->email)->send(new TaskAssigned($task));
        } catch (\Exception $e) {
            // Log the error but don't fail the task creation
            \Log::error('Failed to send task assignment email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Task created and assigned successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'deadline' => 'required|date',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Users can only update their own tasks
        if (auth()->user()->role !== 'admin' && $task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $task->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Task status updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}