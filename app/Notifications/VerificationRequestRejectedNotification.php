<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationRequestRejectedNotification extends Notification
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
        return ['database', 'broadcast'];
        // return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verification Request Rejected')
            ->greeting('Dear ' . $notifiable->full_name)
            ->line('We regret to inform you that your verification request has been reviewed and rejected. We appreciate your interest in becoming verified, but unfortunately, we are unable to approve your request at this time.')
            ->action('More Info', url(route('seller.verification-requests.show', $this->verificationRequest->id)))
            ->line("If you have any questions or need further clarification regarding the rejection, please don't hesitate to reach out to our support team. We are here to assist you and provide any necessary guidance.")
            ->line('Thank you for your understanding.');
    }

    public function toDatabase(object $notifiable)
    {
        $admin = User::where('type', 'Admin')->first();
        return [
            'image' => $admin->photo,
            'body' => 'Unfortunately!, Your Verification Request Has Been Rejected',
            'url' => url(route('seller.verification-requests.show', $this->verificationRequest->id)),
        ];
    }

    public function toBroadcast($notifiable)
    {
        $admin = User::where('type', 'Admin')->first();
        return [
            'image' => $admin->photo,
            'body' => 'Unfortunately!, Your Verification Request Has Been Rejected',
            'url' => url(route('seller.verification-requests.show', $this->verificationRequest->id)),
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
