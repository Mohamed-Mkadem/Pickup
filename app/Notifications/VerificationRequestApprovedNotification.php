<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationRequestApprovedNotification extends Notification
{
    use Queueable;
    protected $verificationRequest;
    /**
     * Create a new notification instance.
     */
    public function __construct($verificationRequest)
    {
        $this->verificationRequest = $verificationRequest;
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
            ->subject('Verification Request Approved')
            ->greeting("Hi {$notifiable->full_name}")
            ->line('We are happy to inform you that your verification request number #' . $this->verificationRequest->id . ' Has Been Reviewed And Approved By Our Team, Now You Are Eligible To Open A Store And Start Earning ')
            ->action('More Info', url(route('seller.verification-requests.show', $this->verificationRequest->id)))
            ->line('Thank you for using our application!');
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
