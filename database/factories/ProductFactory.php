<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_id' => rand(1, 20),
            'name' => fake()->words(2,true),
            'unit' => array_rand(['weight', 'piece', 'liquid'], 1),
            'stock_alert' => rand(1, 60),
            'cost_price' => mt_rand() / mt_getrandmax() * rand(1, 10),
            'price' => mt_rand() / mt_getrandmax() * rand(10, 20),
            'quantity' => rand(10, 100),
            'description' => fake()->sentences(3, true),
            'info' => fake()->sentences(3, true),
            'image' => fake()->imageUrl(100, 100, 'e-commerce', true, null, false, 'jpg'),
        ];
    }
}
