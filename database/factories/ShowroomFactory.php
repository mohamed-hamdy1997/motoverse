<?php

namespace Database\Factories;

use App\Models\Showroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Showroom>
 */
class ShowroomFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->city().' Showroom',
            'city' => fake()->city(),
            'country' => 'Qatar',
            'address' => fake()->streetAddress(),
            'phone' => fake()->phoneNumber(),
            'opening_hours' => 'Sat–Thu · 9:00–21:00',
            'has_service_center' => fake()->boolean(),
        ];
    }
}
