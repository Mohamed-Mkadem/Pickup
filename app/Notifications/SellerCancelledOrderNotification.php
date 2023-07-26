<?php

namespace App\Notifications;

use App\Services\NotificationUrlGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SellerCancelledOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $total;
    public function __construct(public $order, public $status, public $refund, public $banned)
    {
        $this->order = $order;
        $this->status = $status;
        $this->refund = $refund;
        $this->total = $this->refund['value'] + $this->order->amount;
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
        $url = $urlGenerator->generateUrl($this->id, 'client.order.show', $this->order->id);

        if ($this->banned) {
            return (new MailMessage)
                ->subject('Order Update')
                ->greeting("Dear {$notifiable->full_name}")
                ->line("We Regret to inform you that {$this->order->store->name} has been banned because they didn't respect our guidelines.")
                ->line("As a result, all orders placed with this store have been cancelled.")
                ->line("So Your Order Number #{$this->order->id} has been cancelled")
                ->action('More Info', $url)
                ->line("We apologize for any inconvenience caused.")
                ->line("If you have any questions, please don't hesitate to contact our support team.")
                ->line('Thank you for using Pickup!');

        }
        return (new MailMessage)
            ->subject('Order Update')
            ->greeting("Dear {$notifiable->full_name}")
            ->line("We Regret to inform you that {$this->order->store->name} Has Cancelled The Order Number #{$this->order->id}")

            ->line("The Status Of The Order When The Store Owner Cancelled It was '{$this->status}' So You Got {$this->refund['percentage']} Of The Order's Amount which Equals to {$this->refund['value']} TND as a refund, so your account was credited by {$this->total} TND")
            ->action('More Info', $url)

            ->line('Thank you for using Pickup!');
    }
    public function toDatabase(object $notifiable)
    {
        return [
            'image' => $this->order->store->photo,
            'body' => "The Order #{$this->order->id} Was Cancelled By The Store, You Got {$this->refund['percentage']} ({$this->refund['value']} TND) as a Refund",
            'url' => url(route('client.order.show', $this->order->id)),

        ];
    }
    public function toBroadcast(object $notifiable)
    {
        return [
            'image' => $this->order->store->photo,
            'body' => "The Order #{$this->order->id} Was Cancelled By The Store, You Got {$this->refund['percentage']} ({$this->refund['value']} TND) as a Refund",
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
