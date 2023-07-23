<?php

namespace App\Notifications;

use App\Services\NotificationUrlGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketSubmittedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $urlGenerator = app(NotificationUrlGenerator::class);

        $url = $urlGenerator->generateUrl($this->id, 'admin.tickets.show', $this->ticket->id);
        return (new MailMessage)
            ->subject('New Ticket Submitted')
            ->greeting("Hi $notifiable->full_name")
            ->line("{$this->ticket->user->full_name} Submitted a new ticket")
            ->action('More Info', $url)
            ->line('Pickup');
    }
    public function toDatabase(object $notifiable): array
    {
        return [
            'image' => $this->ticket->user->photo,
            'body' => "{$this->ticket->user->full_name} Submitted a new Support Ticket #{$this->ticket->id}",
            'url' => url(route('admin.tickets.show', $this->ticket->id)),
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        return [
            'image' => $this->ticket->user->photo,
            'body' => "{$this->ticket->user->full_name} Submitted a new Support Ticket #{$this->ticket->id}",
            'url' => url(route('admin.tickets.show', $this->ticket->id)),
            'created_at' => time(),
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
