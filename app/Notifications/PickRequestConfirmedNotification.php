<?php

namespace App\Notifications;

use App\Services\NotificationUrlGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PickRequestConfirmedNotification extends Notification
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
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $urlGenerator = app(NotificationUrlGenerator::class);
        $url = $urlGenerator->generateUrl($this->id, 'seller.orders.show', $this->pickRequest->order->id);
        return (new MailMessage)
            ->subject("Pick Request Confirmed")
            ->greeting("Hi {$notifiable->full_name}")
            ->line("Congratulations! {$this->pickRequest->order->client->user->full_name} Confirmed The Pickup Of The Order number #{$this->pickRequest->order->id}")
            ->line("As a result The Order's Amount ({$this->pickRequest->order->amount} TND) was added to your store's balance")
            ->action('More Info', $url)
            ->line('Thank you for using PICKUP!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'image' => $this->pickRequest->order->client->user->photo,
            'body' => "Great news! The order #{$this->pickRequest->order->id} is confirmed, and your store balance has been credited with " . number_format($this->pickRequest->order->amount, 3, ',') . ' TND',
            'url' => url(route('seller.orders.show', $this->pickRequest->order->id)),
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        return [
            'image' => $this->pickRequest->order->client->user->photo,
            'body' => "Great news! The order #{$this->pickRequest->order->id} is confirmed, and your store balance has been credited with " . number_format($this->pickRequest->order->amount, 3, ',') . ' TND',
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
