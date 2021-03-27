<?php

namespace App\Notifications;

use App\Models\JournalEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JournalEntryCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var JournalEntry
     */
    private $journalEntry;

    /**
     * Create a new notification instance.
     *
     * @param JournalEntry $journalEntry
     */
    public function __construct(JournalEntry $journalEntry)
    {
        $this->journalEntry = $journalEntry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
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
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line(
                'Użytkownik ' . $this->journalEntry->author->first_name . ' ' . $this->journalEntry->author->last_name . ' dodał nowy wpis!'
            )
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
            'journal_entry_id' => $this->journalEntry->id,
            'author_id' => $this->journalEntry->user_id,
            'author_fullname' => $this->journalEntry->author->first_name . ' ' . $this->journalEntry->author->last_name,
            'internship_id' => $this->journalEntry->internship->id,
            'internship_name' => $this->journalEntry->internship->offer->name,
        ];
    }
}
