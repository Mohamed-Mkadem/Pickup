<?php

namespace App\Notifications;

use App\Services\NotificationUrlGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PickRequestRejectedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $pickRequest)
    {
        $this->pickRequest = $pickRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $urlGenerator = app(NotificationUrlGenerator::class);
        $url = $urlGenerator->generateUrl($this->id, 'seller.orders.show', $this->pickRequest->order->id);
        return (new MailMessage)
            ->subject("Pick Request Refused")
            ->greeting("Hi {$notifiable->full_name}")
            ->line("We Regret to inform you that {$this->pickRequest->order->client->user->full_name} Refused Your Pick Request Of The Order Number #{$this->pickRequest->order->id}")
            ->line("We Advise You To Try to solve the issue kindly with the client to avoid the order cancellation")
            ->action('More Info', $url)
            ->line('Thank you for using PICKUP!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'image' => $this->pickRequest->order->client->user->photo,
            'body' => "{$this->pickRequest->order->client->user->first_name} Refused Your Pick Request for the order number #{$this->pickRequest->order->id}",
            'url' => url(route('seller.orders.show', $this->pickRequest->order->id)),
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        return [
            'image' => $this->pickRequest->order->client->user->photo,
            'body' => "{$this->pickRequest->order->client->user->first_name} Refused Your Pick Request for the order number #{$this->pickRequest->order->id}",
            'url' => url(route('seller.orders.show', $this->pickRequest->order->id)),
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
