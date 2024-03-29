<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'Pickup',
            'last_name' => 'Ltd',
            'd_o_b' => '1997-12-04',
            'type' => 'Admin',
            'address' => 'Awesome Street Name',
            'state_id' => '2',
            'city_id' => '28',
            'gender' => 'Male',
            'email' => 'admin@pickup.net',
            'password' => Hash::make('developer'),
            'email_verified_at' => '2023-06-09 16:26:02',
            'phone' => '56927726',
            'photo' => 'profiles_photos/default.jpg',
        ]);
    }
}
