<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_id' => Brand::factory(),
            'title' => fake()->sentence(4),
            'highlight' => fake()->randomElement(['0% APR', 'Free Service', 'Save 10%']),
            'description' => fake()->sentence(),
            'starts_at' => today()->subWeek(),
            'ends_at' => today()->addMonth(),
            'is_active' => true,
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'starts_at' => today()->subMonths(2),
            'ends_at' => today()->subMonth(),
        ]);
    }
}
