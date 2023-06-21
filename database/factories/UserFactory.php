<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            // 'name' => fake()->name(),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'd_o_b' => fake()->date('Y-m-d'),
            'phone' => rand($min = (int) 11111111, $max = (int) 99999999),
            'address' => fake()->address(),
            'type' => 'Seller',
            'state_id' => 1,
            'city_id' => 1,
            'gender' => 'Male',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'), // password
        ];
    }
    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
