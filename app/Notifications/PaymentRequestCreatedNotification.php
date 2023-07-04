<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRequestCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $paymentRequest)
    {
        $this->paymentRequest = $paymentRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Add the mail channel later
        return ['database', 'broadcast'];
        // return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Payment Request')
            ->greeting("Hi {$notifiable->full_name} ")
            ->line("{$this->paymentRequest->seller->full_name} Added A New Payment Request")
            ->action('Review', url(route('admin.payment-requests.show', $this->paymentRequest->id)));

    }
    public function toDatabase(object $notifiable)
    {

        return [
            'image' => $this->paymentRequest->seller->user->photo,
            'body' => "{$this->paymentRequest->seller->user->first_name} Added A New Payment Request",
            'url' => url(route('admin.payment-requests.show', $this->paymentRequest->id)),
        ];

    }

    public function toBroadcast(object $notifiable)
    {

        return [
            'image' => $this->paymentRequest->seller->user->photo,
            'body' => "{$this->paymentRequest->seller->user->first_name} Added A New Payment Request",
            'url' => url(route('admin.payment-requests.show', $this->paymentRequest->id)),
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
