<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nid' => rand($min = (int) 11111111, $max = (int) 99999999),
            'rib' => rand($min = (int) 11111111111111111111, $max = (int) 99999999999999999999),
            'bank' => fake()->words(2, true),
            'account_name' => fake()->name(),
            'verification' => 'Verified',
        ];
    }
}
