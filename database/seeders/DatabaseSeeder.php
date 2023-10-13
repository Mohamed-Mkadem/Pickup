<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Brand;
use App\Models\Store;
use App\Models\Sector;
use App\Models\Seller;
use App\Models\Category;
use App\Models\StatusHistory;
use Database\Seeders\FeeSeeder;
use Illuminate\Database\Seeder;
use App\Models\VerificationRequest;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(

            [
                AdminSeeder::class,
                FeeSeeder::class

            ]
        );


    }
}