<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Motorcycle;
use App\Models\Promotion;
use App\Models\Showroom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_only_public_content(): void
    {
        $brand = Brand::factory()->create();
        Brand::factory()->create(['is_active' => false]);

        Motorcycle::factory()->for($brand)->create();
        Motorcycle::factory()->for($brand)->create(['is_published' => false]);

        Promotion::factory()->for($brand)->create();
        Promotion::factory()->for($brand)->expired()->create();
        Promotion::factory()->for($brand)->create(['is_active' => false]);

        Showroom::factory()->count(2)->create();

        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('brands', 1)
                ->has('brands.0.motorcycles', 1)
                ->has('promotions', 1)
                ->has('showrooms', 2)
                ->has('enquiryTypes', 4));
    }
}
