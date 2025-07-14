<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Task Assigned</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 28px;
        }
        .task-details {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .task-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .task-info {
            margin: 10px 0;
        }
        .task-info strong {
            color: #495057;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            background: #ffc107;
            color: white;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🎯 TaskFlow</h1>
            <p>A new task has been assigned to you!</p>
        </div>

        <div class="task-details">
            <div class="task-title">{{ $task->title }}</div>
            
            @if($task->description)
            <div class="task-info">
                <strong>Description:</strong><br>
                {{ $task->description }}
            </div>
            @endif
            
            <div class="task-info">
                <strong>Status:</strong> 
                <span class="status-badge">{{ $task->status }}</span>
            </div>
            
            <div class="task-info">
                <strong>Deadline:</strong> {{ \Carbon\Carbon::parse($task->deadline)->format('F j, Y') }}
            </div>
            
            <div class="task-info">
                <strong>Assigned on:</strong> {{ $task->created_at->format('F j, Y \a\t g:i A') }}
            </div>
        </div>

        <p>Please log into your TaskFlow account to view and manage this task.</p>
        
        <a href="{{ url('/user/tasks') }}" class="btn">View My Tasks</a>

        <div class="footer">
            <p>This email was sent automatically by TaskFlow.<br>
            If you have any questions, please contact your administrator.</p>
            <p>&copy; {{ date('Y') }} TaskFlow. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
