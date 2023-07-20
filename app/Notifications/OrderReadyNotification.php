<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Services\NotificationUrlGenerator;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderReadyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $order)
    {
        $this->order = $order;
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
        $url = $urlGenerator->generateUrl($this->id, 'client.order.show',  $this->order->id);
        return (new MailMessage)
            ->subject('Order Update')
            ->greeting("Dear $notifiable->full_name")
            ->line("{$this->order->store->name} has Prepared your order number #{$this->order->id}, and now your order is ready to pick up")
            ->action('More Info', $url)

            ->line('Thank you for using Pickup!');
    }
    public function toDatabase(object $notifiable)
    {
        return [
            'image' => $this->order->store->photo,
            'body' => "Your Order number #{$this->order->id} Is ready to pick up",
            'url' => url(route('client.order.show', $this->order->id)),
        ];
    }
    public function toBroadcast(object $notifiable)
    {
        return [
            'image' => $this->order->store->photo,
            'body' => "Your Order number #{$this->order->id} Is ready to pick up",
            'url' => url(route('client.order.show', $this->order->id)),
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
