<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body>
    <h1>New Task Assigned</h1>
    <p>Dear {{ $task->user->name }},</p>
    <p>You have been assigned a new task in TaskFlow:</p>
    <ul>
        <li><strong>Title:</strong> {{ $task->title }}</li>
        <li><strong>Description:</strong> {{ $task->description ?? 'N/A' }}</li>
        <li><strong>Deadline:</strong> {{ $task->deadline }}</li>
    </ul>
    <p>Please log in to <a href="{{ env('APP_URL') }}/user/tasks">TaskFlow</a> to view and update the task.</p>
    <p>Thanks,<br>TaskFlow Team</p>
</body>
</html>
