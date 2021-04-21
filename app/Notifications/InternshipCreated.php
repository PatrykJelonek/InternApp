<?php

namespace App\Notifications;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InternshipCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Internship
     */
    private $internship;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @param Internship $internship
     * @param User       $user
     */
    public function __construct(Internship $internship, User $user)
    {
        $this->internship = $internship;
        $this->user = $user;
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
            ->line(
                'Student ' . $this->user->first_name . ' ' . $this->user->last_name . ' o indeksie ' . $this->user->student->student_index . " złożył aplikacje na praktykę " . $this->internship->offer->name
            )
            ->action(
                'Zobacz aplikacje',
                url('/universities/' . $this->internship->agreement->university->slug . '/internships')
            )
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
            'author_id' => $this->user->id,
            'author_fullname' => $this->user->first_name . ' ' . $this->user->last_name,
            'internship_id' => $this->internship->id,
            'internship_name' => $this->internship->offer->name,
        ];
    }
}
