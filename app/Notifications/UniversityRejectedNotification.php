<?php

namespace App\Notifications;

use App\Events\UniversityRejected;
use App\Models\University;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UniversityRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var University
     */
    private $university;

    /**
     * @var string
     */
    private $reason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(University $university, string $reason)
    {
        $this->university = $university;
        $this->reason = $reason;
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
        return ['mail'];
    }

    /**
     * @param $notifiable
     *
     * @return mixed
     */
    public function toMail($notifiable)
    {
        return (new UniversityRejected())($this->university, $this->reason);
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
            //
        ];
    }
}
