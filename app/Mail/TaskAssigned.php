<?php

namespace App\Mail;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssigned extends Mailable {
    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task->load('user'); // Eager load user relationship
    }

    public function build()
    {
        return $this->markdown('emails.task_assigned')
                    ->subject('New Task Assigned');
    }
}
