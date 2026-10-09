<?php

namespace Database\Factories;

use App\Enums\EnquiryStatus;
use App\Enums\EnquiryType;
use App\Models\Brand;
use App\Models\Enquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enquiry>
 */
class EnquiryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(EnquiryType::cases()),
            'status' => EnquiryStatus::New,
            'brand_id' => Brand::factory(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => '+974 5'.fake()->numerify('### ####'),
            'preferred_date' => today()->addDays(fake()->numberBetween(2, 20)),
            'message' => fake()->sentence(),
        ];
    }
}
