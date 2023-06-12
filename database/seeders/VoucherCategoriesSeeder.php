<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoucherCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vouchersCategories = [
            [
                'name' => 'Ashour',
                'icon' => '1.jpg',
                'value' => '10',
                'created_at' => '2017-05-15',
            ],
            [
                'name' => 'Hached',
                'icon' => '2.jpg',
                'value' => '20',
                'created_at' => '2017-06-15',
            ],
            [
                'name' => 'Lgdima',
                'icon' => '3.jpg',
                'value' => '30',
                'created_at' => '2017-07-15',
            ],
            [
                'name' => 'Rabou3',
                'icon' => '4.jpg',
                'value' => '40',
                'created_at' => '2017-08-15',
            ],
            [
                'name' => 'Khaldoun',
                'icon' => '5.jpg',
                'value' => '50',
                'created_at' => '2017-09-15',
            ],
            [
                'name' => 'Moyen',
                'icon' => '6.jpg',
                'value' => '60',
                'created_at' => '2017-10-15',
            ],
            [
                'name' => 'Sabou3',
                'icon' => '7.jpg',
                'value' => '70',
                'created_at' => '2017-11-15',
            ],
            [
                'name' => 'Quatre20',
                'icon' => '8.jpg',
                'value' => '80',
                'created_at' => '2017-12-15',
            ],
            [
                'name' => 'FeTes3in',
                'icon' => '9.jpg',
                'value' => '90',
                'created_at' => '2018-01-15',
            ],
            [
                'name' => 'Dawéma',
                'icon' => '10.jpg',
                'value' => '100',
                'created_at' => '2018-02-15',
            ],
        ];

        foreach ($vouchersCategories as $vouchersCategory) {

            DB::table('voucher_categories')->insert([
                'name' => $vouchersCategory['name'],
                'icon' => 'vouchers_categories/' . $vouchersCategory['icon'],
                'value' => $vouchersCategory['value'],
                'created_at' => $vouchersCategory['created_at'],
            ]);
        }
    }
}
