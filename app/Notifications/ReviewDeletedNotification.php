<?php

namespace App\Notifications;

use App\Models\User;
use App\Services\NotificationUrlGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewDeletedNotification extends Notification
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
            ->subject('Review Deleted')
            ->greeting("Hi $notifiable->full_name")
            ->line("We are writing to inform you about a recent update regarding the review for order #{$this->order->id} ")
            ->line("Unfortunately, after careful review, we found that the review did not adhere to our guidelines and policies. As a result, we have removed the review from your store's profile.")
            ->line("Please be assured that we take our guidelines seriously to ensure a fair and transparent review system for all sellers on our platform.")
            ->line("Due to the review removal, we have recalculated the overall rating of your store based on the remaining reviews. We are pleased to inform you that your store's rating has been updated accordingly.")
            ->line("If you have any questions or concerns regarding this matter, please feel free to reach out to our support team at support@pickup.com.tn , We are here to assist you in any way we can.")
            ->action('More Info', $url)
            ->line('Thank you for using Pickup!');
    }

    public function toDatabase(object $notifiable): array
    {
        $admin = User::where('type', 'Admin')->first();
        return [
            'image' => $admin->photo,
            'body' => "Review for Order #{$this->order->id} has been removed due to guideline violation",
            'url' => route('seller.orders.show', $this->order->id),
        ];
    }
    public function toBroadcast(object $notifiable): array
    {
        $admin = User::where('type', 'Admin')->first();
        return [
            'image' => $admin->photo,
            'body' => "Review for Order #{$this->order->id} has been removed due to guideline violation",
            'url' => route('seller.orders.show', $this->order->id),
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
