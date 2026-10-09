<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Brand;
use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BrandCatalogSeeder::class,
            ShowroomSeeder::class,
        ]);

        $this->seedUsers();
        $this->seedEnquiries();
    }

    /**
     * Demo accounts — all use the password "password".
     */
    private function seedUsers(): void
    {
        User::factory()->create([
            'name' => 'Group Admin',
            'email' => 'admin@motoverse.test',
            'password' => 'password',
            'role' => UserRole::Admin,
        ]);

        User::factory()
            ->create(['name' => 'Urban & Adventure Editor', 'email' => 'editor@motoverse.test', 'password' => 'password'])
            ->brands()->attach(Brand::query()->whereIn('slug', ['volta', 'nomad'])->pluck('id'));

        User::factory()
            ->create(['name' => 'Apex Editor', 'email' => 'apex@motoverse.test', 'password' => 'password'])
            ->brands()->attach(Brand::query()->where('slug', 'apex')->pluck('id'));
    }

    private function seedEnquiries(): void
    {
        Brand::query()->with('motorcycles')->get()->each(function (Brand $brand): void {
            Enquiry::factory()->count(3)->create([
                'brand_id' => $brand->id,
                'motorcycle_id' => $brand->motorcycles->random()->id,
            ]);
        });
    }
}
