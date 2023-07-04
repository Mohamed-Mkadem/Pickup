<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRequestAcceptedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected $paymentRequest)
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment Request Accepted')
            ->greeting("Hi {$notifiable->full_name}")

            ->line("We are pleased to inform you that your payment request Number {$this->paymentRequest->id} has been successfully reviewed and accepted ")
            ->line("The requested amount of {$this->paymentRequest->amount} TND will be transferred to your bank account within the next 3 days.")
            ->action('More Info', url(route('seller.payment-requests.show', $this->paymentRequest->id)))

            ->line('Thank you for your trust in our platform');
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
