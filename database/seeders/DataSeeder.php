<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data = [
        //     [
        //         'user' => [
        //             'first_name' => 'Mohamed',
        //             'last_name' => 'Anwer',
        //             'gender' => 'Male',
        //             'password' => Hash::make('password'),
        //             'created_at' => now(),
        //             'state_id' => 1,
        //             'city_id' => 1,

        //         ],

        //     ],

        // ];
        $faker = Faker::create();

        $data = [];

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'user' => [
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'gender' => $faker->randomElement(['Male', 'Female']),
                    'password' => Hash::make('password'),
                    'created_at' => now(),
                    'state_id' => 1,
                    'city_id' => 1,
                ],
            ];
        }
        for ($i = 0; $i < count($data); $i++) {
            DB::table('users')->insert([
                'first_name' => $data[$i]['user']['first_name'],
                'last_name' => $data[$i]['user']['last_name'],
                'gender' => $data[$i]['user']['gender'],
                'password' => $data[$i]['user']['password'],
                'created_at' => $data[$i]['user']['created_at'],
                'email' => 'test' . $i . '@gmail.com',
                'phone' => '2432514' . $i,
                'd_o_b' => '199' . $i . '-12-04',
                'state_id' => $data[$i]['user']['state_id'],
                'city_id' => $data[$i]['user']['city_id'],
                'address' => $i * 14 . ' Awesome Street name',
                'type' => 'Seller',
            ]);
            DB::table('sellers')->insert([
                'user_id' => $i + 1,
                'rib' => '1214521485201452148' . $i,
                'nid' => '0145214' . $i,
                'account_name' => $data[$i]['user']['first_name'] . ' ' . $data[$i]['user']['last_name'],
                'bank' => 'Zitouna',
            ]);
        }
    }
}
