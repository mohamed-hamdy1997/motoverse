<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Enquiry;
use App\Models\Motorcycle;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

/**
 * Data-entry users may only manage content of the brands assigned to them;
 * admins manage everything.
 */
class BrandScopedAccessTest extends TestCase
{
    use RefreshDatabase;

    private Brand $ownBrand;

    private Brand $otherBrand;

    private User $editor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ownBrand = Brand::factory()->create();
        $this->otherBrand = Brand::factory()->create();

        $this->editor = User::factory()->create();
        $this->editor->brands()->attach($this->ownBrand);
    }

    public function test_editor_only_sees_motorcycles_of_assigned_brands(): void
    {
        Motorcycle::factory()->for($this->ownBrand)->create();
        Motorcycle::factory()->for($this->otherBrand)->count(2)->create();

        $this->actingAs($this->editor)
            ->get(route('admin.motorcycles.index'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/Motorcycles/Index')
                ->has('motorcycles.data', 1)
                ->where('motorcycles.data.0.brand_id', $this->ownBrand->id)
                ->has('brands', 1));
    }

    public function test_admin_sees_all_motorcycles(): void
    {
        Motorcycle::factory()->for($this->ownBrand)->create();
        Motorcycle::factory()->for($this->otherBrand)->count(2)->create();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.motorcycles.index'))
            ->assertInertia(fn (Assert $page) => $page->has('motorcycles.data', 3));
    }

    public function test_editor_cannot_edit_update_or_delete_another_brands_motorcycle(): void
    {
        $foreign = Motorcycle::factory()->for($this->otherBrand)->create();

        $this->actingAs($this->editor);

        $this->get(route('admin.motorcycles.edit', $foreign))->assertForbidden();
        $this->put(route('admin.motorcycles.update', $foreign), $this->motorcyclePayload($this->otherBrand))->assertForbidden();
        $this->delete(route('admin.motorcycles.destroy', $foreign))->assertForbidden();

        $this->assertModelExists($foreign);
    }

    public function test_editor_cannot_create_or_move_a_motorcycle_into_another_brand(): void
    {
        $own = Motorcycle::factory()->for($this->ownBrand)->create();

        $this->actingAs($this->editor);

        $this->post(route('admin.motorcycles.store'), $this->motorcyclePayload($this->otherBrand))
            ->assertSessionHasErrors('brand_id');

        $this->put(route('admin.motorcycles.update', $own), $this->motorcyclePayload($this->otherBrand))
            ->assertSessionHasErrors('brand_id');

        $this->assertSame($this->ownBrand->id, $own->fresh()->brand_id);
    }

    public function test_editor_can_create_a_motorcycle_with_an_image_for_their_brand(): void
    {
        Storage::fake('public');

        $this->actingAs($this->editor)
            ->post(route('admin.motorcycles.store'), [
                ...$this->motorcyclePayload($this->ownBrand),
                'image' => UploadedFile::fake()->image('bike.jpg', 1200, 800),
            ])
            ->assertRedirect(route('admin.motorcycles.index'));

        $motorcycle = Motorcycle::query()->sole();
        $this->assertSame('test-bike', $motorcycle->slug);
        Storage::disk('public')->assertExists($motorcycle->image);
    }

    public function test_motorcycle_input_is_validated(): void
    {
        $this->actingAs($this->editor)
            ->post(route('admin.motorcycles.store'), ['brand_id' => $this->ownBrand->id, 'price' => -5, 'category' => 'spaceship'])
            ->assertSessionHasErrors(['name', 'price', 'category', 'power_hp', 'weight_kg']);
    }

    public function test_editor_can_only_update_promotions_of_assigned_brands(): void
    {
        $own = Promotion::factory()->for($this->ownBrand)->create();
        $foreign = Promotion::factory()->for($this->otherBrand)->create();

        $payload = fn (Brand $brand) => [
            'brand_id' => $brand->id,
            'title' => 'Updated title',
            'highlight' => 'Save 5%',
            'description' => 'Updated.',
            'starts_at' => today()->toDateString(),
            'ends_at' => today()->addWeek()->toDateString(),
            'is_active' => true,
        ];

        $this->actingAs($this->editor);

        $this->put(route('admin.promotions.update', $own), $payload($this->ownBrand))->assertRedirect(route('admin.promotions.index'));
        $this->assertSame('Updated title', $own->fresh()->title);

        $this->put(route('admin.promotions.update', $foreign), $payload($this->otherBrand))->assertForbidden();
    }

    public function test_editor_can_update_own_brand_profile_but_not_create_or_delete_brands(): void
    {
        $this->actingAs($this->editor);

        $this->get(route('admin.brands.edit', $this->ownBrand))->assertOk();
        $this->get(route('admin.brands.edit', $this->otherBrand))->assertForbidden();
        $this->get(route('admin.brands.create'))->assertForbidden();
        $this->delete(route('admin.brands.destroy', $this->ownBrand))->assertForbidden();
    }

    public function test_editor_only_sees_and_updates_enquiries_of_assigned_brands(): void
    {
        $own = Enquiry::factory()->for($this->ownBrand)->create();
        $foreign = Enquiry::factory()->for($this->otherBrand)->create();
        Enquiry::factory()->create(['brand_id' => null]);

        $this->actingAs($this->editor);

        $this->get(route('admin.enquiries.index'))
            ->assertInertia(fn (Assert $page) => $page->has('enquiries.data', 1)->where('enquiries.data.0.id', $own->id));

        $this->put(route('admin.enquiries.update', $own), ['status' => 'contacted'])->assertRedirect();
        $this->put(route('admin.enquiries.update', $foreign), ['status' => 'contacted'])->assertForbidden();
        $this->delete(route('admin.enquiries.destroy', $own))->assertForbidden();
    }

    public function test_user_management_is_admin_only(): void
    {
        $this->actingAs($this->editor)->get(route('admin.users.index'))->assertForbidden();

        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => 'New Editor',
                'email' => 'new.editor@example.com',
                'role' => 'data_entry',
                'password' => 'secret-password',
                'password_confirmation' => 'secret-password',
                'brand_ids' => [$this->otherBrand->id],
            ])
            ->assertRedirect(route('admin.users.index'));

        $created = User::query()->where('email', 'new.editor@example.com')->sole();
        $this->assertSame([$this->otherBrand->id], $created->managedBrandIds());

        $this->delete(route('admin.users.destroy', $admin))->assertForbidden();
    }

    public function test_data_entry_user_requires_at_least_one_brand(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.users.store'), [
                'name' => 'No Brands',
                'email' => 'no.brands@example.com',
                'role' => 'data_entry',
                'password' => 'secret-password',
                'password_confirmation' => 'secret-password',
                'brand_ids' => [],
            ])
            ->assertSessionHasErrors('brand_ids');
    }

    /**
     * @return array<string, mixed>
     */
    private function motorcyclePayload(Brand $brand): array
    {
        return [
            'brand_id' => $brand->id,
            'name' => 'Test Bike',
            'category' => 'naked',
            'price' => 45000,
            'engine_cc' => 890,
            'power_hp' => 115,
            'weight_kg' => 180,
            'description' => 'A test motorcycle.',
            'is_featured' => false,
            'is_published' => true,
        ];
    }
}
