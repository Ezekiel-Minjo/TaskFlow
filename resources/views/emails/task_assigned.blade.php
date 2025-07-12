<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body class="font-sans bg-gray-50">
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-sm">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">New Task Assigned</h1>
        <p class="mb-4">Dear {{ $task->user->name ?? 'User' }},</p>
        <p class="mb-6">You have been assigned a new task in {{ config('app.name') }}:</p>

        <ul class="mb-6 space-y-2">
            <li><strong class="font-semibold">Title:</strong> {{ $task->title ?? 'N/A' }}</li>
            <li><strong class="font-semibold">Description:</strong> {{ $task->description ?? 'No description provided' }}</li>
            <li><strong class="font-semibold">Deadline:</strong>
                {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('F j, Y') : 'No deadline set' }}
            </li>
        </ul>

        <div class="mb-6">
            <p>Please log in to
                <a href="{{ config('app.url') }}/user/tasks" class="text-blue-600 hover:underline">
                    {{ config('app.name') }}
                </a>
                to view and update the task.
            </p>
        </div>

        <p class="text-gray-600">
            Thanks,<br>
            <span class="font-medium">{{ config('app.name') }} Team</span>
        </p>
    </div>
</body>
</html>
