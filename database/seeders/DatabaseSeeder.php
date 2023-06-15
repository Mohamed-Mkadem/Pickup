<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\User;
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

        User::factory(80)
            ->has(Client::factory(1)

                , 'client')
            ->create();
        // User::factory(10)
        //     ->has(Seller::factory(1)
        //             ->has(VerificationRequest::factory(1)
        //                     ->has(StatusHistory::factory(1), 'statusHistories')
        //                 , 'verificationRequests')
        //         , 'seller')
        //     ->create();

    }
}
