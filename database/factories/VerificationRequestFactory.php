<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VerificationRequest>
 */
class VerificationRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'photo' => '/v_reqs/default.jpg',
            'nid_front' => '/v_reqs/default.jpg',
            'nid_back' => '/v_reqs/default.jpg',
            'commercial_register' => '/v_reqs/default.jpg',
        ];
    }
}
