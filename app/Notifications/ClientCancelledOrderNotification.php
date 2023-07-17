<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientCancelledOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $order, public $status, public $refund)
    {
        $this->order = $order;
        $this->status = $status;
        $this->refund = $refund;
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
        return (new MailMessage)
            ->subject('Order Update')
            ->greeting("Dear {$notifiable->full_name}")
            ->line("We Regret to inform you that {$this->order->client->user->full_name} Has Cancelled His Order Number #{$this->order->id}")

            ->line("The Status Of The Order When The Client Cancelled It was '{$this->status}' So You Got {$this->refund['percentage']}% Of The Order's Amount which Equals to {$this->refund['value']} TND")
            ->action('More Info', url(route('seller.orders.show', $this->order->id)))
            ->line('Thank you for using Pickup!');
    }

    public function toDatabase(object $notifiable)
    {
        return [
            'image' => $this->order->client->user->photo,
            'body' => "The Order #{$this->order->id} Was Cancelled By The Client, You Got {$this->refund['percentage']}% ({$this->refund['value']}) TND as a Refund",
            'url' => url(route('seller.orders.show', $this->order->id)),

        ];
    }
    public function toBroadcast(object $notifiable)
    {
        return [
            'image' => $this->order->client->user->photo,
            'body' => "The Order #{$this->order->id} Was Cancelled By The Client, You Got {$this->refund['percentage']}% ({$this->refund['value']}) TND as a Refund",
            'url' => url(route('seller.orders.show', $this->order->id)),
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
