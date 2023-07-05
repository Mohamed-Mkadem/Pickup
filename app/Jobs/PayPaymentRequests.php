<?php

namespace App\Jobs;

use App\Events\PaymentRequestPaid;
use App\Models\PaymentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class PayPaymentRequests implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $paymentRequests = PaymentRequest::where('status', 'accepted')
            ->whereDate('updated_at', '<=', Carbon::now()->subDays(3))
            ->get();
        foreach ($paymentRequests as $paymentRequest) {
            $paymentRequest->status = 'paid';
            $paymentRequest->save();

            $paymentRequest->statusHistories()->create([
                'action' => 'Paid',
                'statusable_type' => 'App\Models\PaymentRequest',
                'statusable_id' => $paymentRequest->id,
            ]);
            event(new PaymentRequestPaid($paymentRequest));
        }
    }
}
