<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Délice',
                'logo' => 'brands/delice.jpg',
                'status' => 'Active',
                'description' => 'lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 ',
                'created_at' => '2029-01-19 03:34:37',

            ],
            [
                'name' => 'Vitalait',
                'logo' => 'brands/vitalait.jpg',
                'status' => 'Inactive',
                'description' => 'lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 ',
                'created_at' => '2021-09-19 03:34:37',

            ],
            [
                'name' => 'Tom',
                'logo' => 'brands/tom.jpg',
                'status' => 'Active',
                'description' => 'lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 ',
                'created_at' => '2019-01-19 03:34:37',

            ],
            [
                'name' => 'President',
                'logo' => 'brands/president.jpg',
                'status' => 'Inactive',
                'description' => 'lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 ',
                'created_at' => '2025-01-19 03:34:37',

            ],
            [
                'name' => 'Saida',
                'logo' => 'brands/saida.jpg',
                'status' => 'Active',
                'description' => 'lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 ',
                'created_at' => '2012-01-19 03:34:37',

            ],
            [
                'name' => 'Randa',
                'logo' => 'brands/randa.jpg',
                'status' => 'Active',
                'description' => 'lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 lorem10 ',
                'created_at' => '2021-01-19 03:34:37',

            ],
        ];
        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'name' => $brand['name'],
                'logo' => $brand['logo'],
                'status' => $brand['status'],
                'description' => $brand['description'],
                'created_at' => $brand['created_at'],
            ]);
        }
    }
}
