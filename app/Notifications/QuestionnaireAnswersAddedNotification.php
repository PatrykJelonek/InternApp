<?php

namespace App\Notifications;

use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionnaireAnswersAddedNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Questionnaire
     */
    private $questionnaire;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Questionnaire $questionnaire)
    {
        $this->user = $user;
        $this->questionnaire = $questionnaire;
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
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'text' => $this->user->first_name . ' ' . $this->user->last_name . ' wypełnił ankietę ' . $this->questionnaire->name,
            'author' => $this->user->first_name . ' ' . $this->user->last_name,
            'questionnaire_name' => $this->questionnaire->name,
            'questionnaire_id' => $this->questionnaire->id,
        ];
    }

    /**
     * @param $notifiable
     *
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage(
            [
                'data' => [
                    'text' => $this->user->first_name . ' ' . $this->user->last_name . ' wypełnił ankietę ' . $this->questionnaire->name,
                    'author' => $this->user->first_name . ' ' . $this->user->last_name,
                    'questionnaire_name' => $this->questionnaire->name,
                    'questionnaire_id' => $this->questionnaire->id,
                ]
            ]
        );
    }
}
