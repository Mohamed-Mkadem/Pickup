<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VerificationRequestCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $verificationRequest;
    public $seller;

    /**
     * Create a new notification instance.
     */
    public function __construct($verificationRequest, $seller)
    {
        $this->verificationRequest = $verificationRequest;
        $this->seller = $seller;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
