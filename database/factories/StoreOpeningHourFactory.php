<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StoreOpeningHour>
 */
class StoreOpeningHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $weekDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($weekDays as $day) {
            return [
                $day => [
                    'opening_time' => '08:00',
                    'closing_time' => '18:30',
                ],
            ];
        };
        // 'monday' => [

        // ],
        // 'tuesday' => [
        //     'opening_time' => '08:00',
        //     'closing_time' => '18:30',
        // ],
        // 'wednesday' => [
        //     'opening_time' => '08:00',
        //     'closing_time' => '18:30',
        // ],
        // 'thursday' => [
        //     'opening_time' => '08:00',
        //     'closing_time' => '18:30',
        // ],
        // 'friday' => [
        //     'opening_time' => '08:00',
        //     'closing_time' => '18:30',
        // ],
        // 'saturday' => [
        //     'opening_time' => '08:00',
        //     'closing_time' => '18:30',
        // ],
        // 'sunday' => [
        //     'opening_time' => '08:00',
        //     'closing_time' => '18:30',
        // ],
    }
}
