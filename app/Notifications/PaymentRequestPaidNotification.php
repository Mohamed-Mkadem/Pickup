<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Services\NotificationUrlGenerator;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentRequestPaidNotification extends Notification
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
            ->subject('Payment Request Update: Payment Successfully Transferred')
            ->greeting("Dear {$notifiable->full_name}")

            ->line("We are pleased to inform you that your payment request, numbered #{$this->paymentRequest->id}, with the amount of {$this->paymentRequest->amount} TND , has been accepted and the payment has been successfully transferred to your bank account.")
            ->line('Payment Request Details : ')
            ->line("Payment Request Number: #{$this->paymentRequest->id}")
            ->line("Payment Request Amount: {$this->paymentRequest->amount} TND")
            ->line("Date of Request Placement: {$this->paymentRequest->created_at->format('d-m-Y : H:i')}")
            ->line("Date of Acceptance: {$this->paymentRequest->updated_at->format('d-m-Y : H:i')}")

            ->action('More Details', $url)
            ->line('Thank you for using our platform and congratulations on the successful completion of your payment request.');
    }

    public function toDatabase(Object $notifiable)
    {
        $admin = User::where('type', 'Admin')->first();
        return [
            'image' => $admin->photo,
            'body' => "Congratulations!, Your Payment Request #{$this->paymentRequest->id} Has Been Paid",
            'url' => url(route('seller.payment-requests.show', $this->paymentRequest->id)),
        ];
    }
    public function toBroadcast(Object $notifiable)
    {
        $admin = User::where('type', 'Admin')->first();
        return [
            'image' => $admin->photo,
            'body' => "Congratulations!, Your Payment Request #{$this->paymentRequest->id} Has Been Paid",
            'url' => url(route('seller.payment-requests.show', $this->paymentRequest->id)),
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
