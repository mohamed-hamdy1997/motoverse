<?php

namespace Database\Factories;

use App\Enums\BrandSegment;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'segment' => fake()->randomElement(BrandSegment::cases()),
            'tagline' => fake()->catchPhrase(),
            'description' => fake()->paragraph(),
            'accent_color' => fake()->hexColor(),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
