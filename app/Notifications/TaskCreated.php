<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Task
     */
    private $task;

    /**
     * Create a new notification instance.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line($this->task->user->first_name . ' ' . $this->task->user->last_name . ' dodał nowe zadanie ' . $this->task->name . ' w praktyce ' . $this->task->internship->offer->name)
            ->action('Zobacz', url('/internships/'.$this->task->internship->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'author_id' => $this->task->user->id,
            'author_fullname' => $this->task->user->first_name . ' ' . $this->task->user->last_name,
            'internship_id' => $this->task->internship->id,
            'internship_name' => $this->task->internship->offer->name,
        ];
    }
}
