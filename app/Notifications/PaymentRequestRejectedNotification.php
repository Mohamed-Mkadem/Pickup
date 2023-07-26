<?php

namespace App\Notifications;

use App\Models\User;
use App\Services\NotificationUrlGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRequestRejectedNotification extends Notification
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
        return ['mail','database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $urlGenerator = app(NotificationUrlGenerator::class);
        $url = $urlGenerator->generateUrl($this->id, 'seller.payment-requests.show', $this->paymentRequest->id);
        return (new MailMessage)
            ->subject('Important Update: Rejection of Your Payment Request')
            ->greeting("Dear $notifiable->full_name,")
            ->line("We regret to inform you that your payment request Number #{$this->paymentRequest->id} (Amount : {$this->paymentRequest->amount} TND) has been reviewed and unfortunately, it has been rejected")
            ->action('More Details', $url)
            ->line('If you have any questions or concerns regarding the rejection, please feel free to contact our support team for further clarification and assistance.')
            ->line('Thank you for your trust in our platform');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */

    public function toDatabase(Object $notifiable)
    {
        $admin = User::where('type', 'Admin')->first();
        return [
            'image' => $admin->photo,
            'body' => "Unfortunately!, Your Payment Request #{$this->paymentRequest->id} Has Been Rejected",
            'url' => url(route('seller.payment-requests.show', $this->paymentRequest->id)),
        ];
    }
    public function toBroadcast(Object $notifiable)
    {
        $admin = User::where('type', 'Admin')->first();
        return [
            'image' => $admin->photo,
            'body' => "Unfortunately!, Your Payment Request #{$this->paymentRequest->id} Has Been Rejected",
            'url' => url(route('seller.payment-requests.show', $this->paymentRequest->id)),
            'created_at' => time(),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
