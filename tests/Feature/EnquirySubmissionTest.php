<?php

namespace Tests\Feature;

use App\Enums\EnquiryStatus;
use App\Models\Enquiry;
use App\Models\Motorcycle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnquirySubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_book_a_test_ride_and_it_is_routed_to_the_models_brand(): void
    {
        $motorcycle = Motorcycle::factory()->create();

        $this->post(route('enquiries.store'), [
            'type' => 'test_ride',
            'motorcycle_id' => $motorcycle->id,
            'name' => 'Sara Al-Kuwari',
            'email' => 'sara@example.com',
            'phone' => '+974 5555 1234',
            'preferred_date' => today()->addDays(3)->toDateString(),
        ])->assertRedirect()->assertSessionHas('success');

        $enquiry = Enquiry::query()->sole();
        $this->assertSame($motorcycle->brand_id, $enquiry->brand_id);
        $this->assertSame(EnquiryStatus::New, $enquiry->status);
    }

    public function test_test_ride_requires_a_published_model(): void
    {
        $draft = Motorcycle::factory()->create(['is_published' => false]);

        $this->post(route('enquiries.store'), [
            'type' => 'test_ride',
            'name' => 'Sara',
            'email' => 'sara@example.com',
            'phone' => '+974 5555 1234',
        ])->assertSessionHasErrors('motorcycle_id');

        $this->post(route('enquiries.store'), [
            'type' => 'test_ride',
            'motorcycle_id' => $draft->id,
            'name' => 'Sara',
            'email' => 'sara@example.com',
            'phone' => '+974 5555 1234',
        ])->assertSessionHasErrors('motorcycle_id');

        $this->assertDatabaseCount('enquiries', 0);
    }

    public function test_enquiry_input_is_validated(): void
    {
        $this->post(route('enquiries.store'), [
            'type' => 'not-a-type',
            'email' => 'not-an-email',
            'phone' => 'abc',
            'preferred_date' => today()->subDay()->toDateString(),
        ])->assertSessionHasErrors(['type', 'name', 'email', 'phone', 'preferred_date']);
    }

    public function test_enquiries_are_rate_limited(): void
    {
        $payload = ['type' => 'sales', 'name' => 'Sara', 'email' => 'sara@example.com', 'phone' => '+974 5555 1234'];

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('enquiries.store'), $payload)->assertRedirect();
        }

        $this->post(route('enquiries.store'), $payload)->assertTooManyRequests();
    }
}
