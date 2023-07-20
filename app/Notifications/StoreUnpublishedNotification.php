<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StoreUnpublishedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
       
        return (new MailMessage)
            ->subject('Store Subscription Expired')
            ->from('stores@pickup.com.tn', 'Stores Center')
            ->greeting("Hi {$notifiable->full_name} ")

            ->line(' We would like to inform you that the expiry date for your store has passed, and your store is currently unpublished. ')

            ->line('To continue showcasing your products and services on our platform, we kindly request you to purchase a new subscription and republish your store.')

            ->action('Purchase A New Subscription', url(route('seller.stores.subscriptions.create')))
            ->line('Thank you for choosing our platform.');
    }
    public function toDatabase(object $notifiable)
    {

        $admin = User::where('type', 'Admin')->first();
        return [
            'image' => $admin->photo,
            'body' => 'The expiry date for your store has passed',
            'url' => url(route('seller.stores.show', $notifiable->seller->store->username)),

        ];
    }
    public function toBroadcast(object $notifiable)
    {

        $admin = User::where('type', 'Admin')->first();
        return [
            'image' => $admin->photo,
            'body' => 'The expiry date for your store has passed',
            'url' => url(route('seller.stores.show', $notifiable->seller->store->username)),
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
