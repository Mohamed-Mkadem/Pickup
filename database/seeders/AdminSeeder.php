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
            'first_name' => 'Mohamed',
            'last_name' => 'Mkadem',
            'd_o_b' => '1997-12-04',
            'type' => 'Admin',
            'address' => 'Awesome Street Name',
            'state_id' => '2',
            'city_id' => '28',
            'gender' => 'Male',
            'email' => 'mkademhamma19@gmail.com',
            'password' => Hash::make('developer'),
            'email_verified_at' => '2023-06-09 16:26:02',
            'phone' => '56927726',
            'photo' => 'profiles_photos/default.jpg',
        ]);
    }
}
