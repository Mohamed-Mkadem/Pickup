<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationRequestCreatedNotification extends Notification
{
    use Queueable;

    protected $verificationRequest;
    protected $seller;

    /**
     * Create a new notification instance.
     */
    public function __construct($verificationRequest, $seller)
    {
        $this->verificationRequest = $verificationRequest;
        $this->seller = $seller;
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
            ->subject('New Verification Request')
            ->greeting('HI ' . $notifiable->full_name)
            ->line($this->seller->full_name . ' Submitted A Verification Request')
            ->action('Review', url(route('admin.verification-requests.show', $this->verificationRequest->id)));

    }

    /**
     * Get the database representation of the notification.
     */

    public function toDatabase($notifiable)
    {
        return [
            'image' => $this->seller->user->photo,
            'body' => $this->seller->full_name . ' Submitted A Verification Request',
            'url' => url(route('admin.verification-requests.show', $this->verificationRequest->id)),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'image' => $this->seller->user->photo,
            'body' => $this->seller->full_name . ' Submitted A Verification Request',
            'url' => url(route('admin.verification-requests.show', $this->verificationRequest->id)),
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
