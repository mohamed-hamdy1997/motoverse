<?php

namespace Database\Factories;

use App\Enums\MotorcycleCategory;
use App\Models\Brand;
use App\Models\Motorcycle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Motorcycle>
 */
class MotorcycleFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'brand_id' => Brand::factory(),
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'category' => fake()->randomElement(MotorcycleCategory::cases()),
            'price' => fake()->numberBetween(8_000, 120_000),
            'engine_cc' => fake()->numberBetween(125, 1900),
            'power_hp' => fake()->numberBetween(10, 210),
            'weight_kg' => fake()->numberBetween(110, 380),
            'description' => fake()->sentence(),
            'is_featured' => false,
            'is_published' => true,
        ];
    }
}
