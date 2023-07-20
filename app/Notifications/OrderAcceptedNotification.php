<?php

namespace App\Notifications;

use App\Services\NotificationUrlGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderAcceptedNotification extends Notification
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
        $url = $urlGenerator->generateUrl($this->id, 'client.order.show', $this->order->id);
        return (new MailMessage)

            ->subject('Order Update')
            ->greeting("Dear $notifiable->full_name")
            ->line("Congratulations! {$this->order->store->name} has Accepted your order number #{$this->order->id}, We will notify you when your order Is ready")
            ->action('More Info', $url)

            ->line('Thank you for using Pickup!');
    }
    public function toDatabase(object $notifiable)
    {
        return [
            'image' => $this->order->store->photo,
            'body' => "Congratulations! {$this->order->store->name} Accepted Your Order Number #{$this->order->id}",
            'url' => url(route('client.order.show', $this->order->id)),
        ];
    }
    public function toBroadcast(object $notifiable)
    {
        return [
            'image' => $this->order->store->photo,
            'body' => "Congratulations! {$this->order->store->name} Accepted Your Order Number #{$this->order->id}",
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
