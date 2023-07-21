<?php

namespace App\Notifications;

use App\Services\NotificationUrlGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $store;
    public $client;
    public $order;
    public function __construct(public $review)
    {
        $this->review = $review;
        $this->order = $review->order;
        $this->store = $review->store;
        $this->client = $review->client->user;
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
        $url = $urlGenerator->generateUrl($this->id, 'seller.orders.show', $this->order->id);
        return (new MailMessage)
            ->subject("New Review Received")
            ->greeting("Hi {$notifiable->full_name}")
            ->line(" We are excited to inform you that {$this->client->full_name} has just added a review for his recent order from your store")
            ->line("Order Number : {$this->order->id}")
            ->line("Review Details : ")
            ->line("Total Rate : {$this->review->total}")
            ->line("Hospitality : {$this->review->hospitality}")
            ->line("Commitment : {$this->review->commitment}")
            ->line("Honesty : {$this->review->honesty}")
            ->line("Feedback :" . $this->review->honesty ?? "The Client Doesn't Provide a feedback")
            ->action('More Info', $url)
            ->line('We value the feedback of our clients, and your dedication to providing an excellent shopping experience reflects positively on your store. Thank you for your commitment to quality service.')
            ->line("If you have any questions or concerns regarding the review or the order, please feel free to reach out to us. We're here to support you.")
            ->line('Thank you for using Pickup!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'image' => $this->client->photo,
            'body' => 'Great news! A customer left a review for their order',
            'url' => url(route('seller.orders.show', $this->order->id)),
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        return [
            'image' => $this->client->photo,
            'body' => 'Great news! A customer left a review for their order',
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
