<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class MessageSentNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    private $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
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
        return ['database','broadcast'];
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
    public function toArray($notifiable)
    {
        return [
            'text' => 'Nowa wiadomość od ' . $this->message->user->first_name . ' ' . $this->message->user->last_name,
            'author' => $this->message->user->first_name . ' ' . $this->message->user->last_name,
            'content' => $this->message->content,
            'chat_uuid' => $this->message->chat_uuid,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage(
            [
                'data' => [
                    'text' => 'Nowa wiadomość od ' . $this->message->user->first_name . ' ' . $this->message->user->last_name,
                    'author' => $this->message->user->first_name . ' ' . $this->message->user->last_name,
                    'content' => $this->message->content,
                    'chat_uuid' => $this->message->chat_uuid,
                ]
            ]
        );
    }
}
