<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sector_id' => rand(1, 10),
            'address' => fake()->address(),
            'state_id' => '1',
            'city_id' => '1',
            'name' => fake()->unique()->word(),
            'username' => fake()->unique()->word(),
            'phone' => rand($min = (int) 11111111, $max = (int) 99999999),
            'bio' => fake()->sentences(3, true),

        ];
    }
}
