<?php

namespace App\Notifications;

use App\Services\NotificationUrlGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketResponseCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $sender, public $ticket)
    {
        $this->sender = $sender;
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $urlGenerator = app(NotificationUrlGenerator::class);

        $url = $urlGenerator->generateUrl($this->id, $this->getRoute(), $this->ticket->id);
        return (new MailMessage)
            ->subject("New Response On Ticket Number #{$this->ticket->id}")
            ->greeting("Hi {$notifiable->full_name}")
            ->line("The Ticket number #{$this->ticket->id} ({$this->ticket->title}) has a new response from {$this->sender->full_name}")
            ->action('More Info', $url)
            ->line('Thank you for using Pickup!');
    }
    public function toDatabase(object $notifiable): array
    {
        return [
            'image' => $this->sender->photo,
            'body' => "The Ticket number #{$this->ticket->id} has a new response from {$this->sender->full_name}",
            'url' => url(route($this->getRoute(), $this->ticket->id)),
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        return [
            'image' => $this->sender->photo,
            'body' => "The Ticket number #{$this->ticket->id} has a new response from {$this->sender->full_name}",
            'url' => url(route($this->getRoute(), $this->ticket->id)),
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

    private function getRoute()
    {
        $route = 'client.tickets.show';
        if (!$this->sender->isAdmin()) {
            $route = 'admin.tickets.show';

        } else {
            if ($this->ticket->user->isSeller()) {

                $route = 'seller.tickets.show';
            }
        }
        return $route;
    }
}
