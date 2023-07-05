<?php

namespace App\Jobs;

use App\Events\StoreUnpublished;
use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckStoresExpiryDate implements ShouldQueue
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
        $today = date('Y-m-d'); 
        $publishedStores = Store::where('status', 'published')->get();
        foreach ($publishedStores as $store) {
            if ($today > $store->expiry_date) {
                $store->status = 'unpublished';
                $store->save();
                $owner = $store->owner->user;
                // $owner->notify(new StoreUnpublishedNotification());
                event(new StoreUnpublished($owner));

            }

        }
    }
}
