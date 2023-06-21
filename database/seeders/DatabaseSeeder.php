<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Sector;
use App\Models\Seller;
use App\Models\StatusHistory;
use App\Models\Store;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(

            [
                AdminSeeder::class,
                // BrandsSeeder::class,
                // VoucherCategoriesSeeder::class,
            ]);
        // Client Factory (check userFactory File)
        // User::factory(80)
        //     ->has(Client::factory(1)

        //         , 'client')
        //     ->create();
        // Seller Factory (check userFactory File)
        Sector::factory(10)->create();
        User::factory(50)
            ->has(Seller::factory(1)
                    ->has(VerificationRequest::factory(1)
                            ->has(StatusHistory::factory(1), 'statusHistories')
                        , 'verificationRequests')
                    ->has(Store::factory(1), 'store')
                , 'seller')
            ->create();

    }
}
