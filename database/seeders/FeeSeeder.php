<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fees')->insert([
            'name' => 'subscription',
            'value' => 29.00,
            'method' => 'Monthly',
            'features' => "<ul><li>No Engagement Required</li><li>Your Store Will be Published all the subscription Period</li><li>No Hidden Fees</li></ul>"
        ]);
    }
}
