<?php

namespace App\Notifications;

use App\Services\NotificationUrlGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PickRequestCreatedNotification extends Notification
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
        return ['database', 'broadcast'];
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $urlGenerator = app(NotificationUrlGenerator::class);
        $url = $urlGenerator->generateUrl($this->id, 'client.order.show', $this->pickRequest->order->id);
        return (new MailMessage)
            ->subject('New Pick Request')
            ->greeting("HI {$notifiable->full_name}")
            ->line("{$this->pickRequest->order->store->name} Sent You a Pick Request for the order number #{$this->pickRequest->order->id}")

            ->action('More Info', $url)
            ->line('Thank you for using PICKUP!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'image' => $this->pickRequest->order->store->photo,
            'body' => "{$this->pickRequest->order->store->name} Sent You a Pick Request for the order number #{$this->pickRequest->order->id}",
            'url' => url(route('client.order.show', $this->pickRequest->order->id)),
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        return [
            'image' => $this->pickRequest->order->store->photo,
            'body' => "{$this->pickRequest->order->store->name} Sent You a Pick Request for the order number #{$this->pickRequest->order->id}",
            'url' => url(route('client.order.show', $this->pickRequest->order->id)),
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
