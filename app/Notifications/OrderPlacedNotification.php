<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification
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
        return (new MailMessage)
            ->subject('New Order')
            ->greeting("Hi {$notifiable->full_name}")
            ->line("We are delighted to inform you that an order has been placed by a client on Pickup. Here are the details of the order:")
            ->line("Order Number : {$this->order->id}")
            ->line("Order Items : {$this->order->no_items}")
            ->line("Order Amount : " . number_format($this->order->amount, 3, ','))
            ->line("Order Date : " . $this->order->created_at->format('M jS Y H:i'))

            ->action('More Info', url(route('seller.orders.show', $this->order->id)))
            ->line('Thank you for using Pickup. We appreciate your business!')
            ->line('Best regards')
            ->line('Pickup Team');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'image' => $this->order->client->user->photo,
            'body' => "Great news! You Have A Wew Order With Total Amount Of " . number_format($this->order->amount, 3, ',') . " DT",
            'url' => url(route('seller.orders.show', $this->order->id)),
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        return [
            'image' => $this->order->client->user->photo,
            'body' => "Great news! You Have A Wew Order With Total Amount Of " . number_format($this->order->amount, 3, ',') . " DT",
            'url' => url(route('seller.orders.show', $this->order->id)),
            'created_at' => time(),
        ];
    }
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
