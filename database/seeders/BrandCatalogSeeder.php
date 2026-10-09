<?php

namespace Database\Seeders;

use App\Enums\BrandSegment;
use App\Enums\MotorcycleCategory;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds the fictional MotoVerse brand portfolio, its line-up and running promotions.
 */
class BrandCatalogSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->catalog() as $sortOrder => $entry) {
            $brand = Brand::query()->create([
                ...$entry['brand'],
                'slug' => Str::slug($entry['brand']['name']),
                'sort_order' => $sortOrder,
                'is_active' => true,
            ]);

            foreach ($entry['motorcycles'] as $motorcycle) {
                $brand->motorcycles()->create([
                    ...$motorcycle,
                    'slug' => Str::slug($entry['brand']['name'].' '.$motorcycle['name']),
                    'image' => 'images/models/'.Str::slug($entry['brand']['name'].' '.$motorcycle['name']).'.jpg',
                    'is_published' => true,
                ]);
            }

            $brand->promotions()->create([
                ...$entry['promotion'],
                'starts_at' => today()->subDays(10),
                'ends_at' => today()->addDays(45),
                'is_active' => true,
            ]);
        }

        Brand::query()->where('slug', 'apex')->first()?->promotions()->create([
            'title' => 'Summer Track Season',
            'highlight' => 'Ended',
            'description' => 'An expired promotion kept to demonstrate date-window filtering on the public site.',
            'starts_at' => today()->subMonths(4),
            'ends_at' => today()->subMonths(2),
            'is_active' => true,
        ]);
    }

    /**
     * @return array<int, array{brand: array<string, mixed>, motorcycles: array<int, array<string, mixed>>, promotion: array<string, string>}>
     */
    private function catalog(): array
    {
        return [
            [
                'brand' => [
                    'name' => 'Volta',
                    'segment' => BrandSegment::UrbanMobility,
                    'tagline' => 'Electric-first. City-smart.',
                    'description' => 'Volta builds quiet, connected machines for the daily commute — from nimble scooters that slip through Doha traffic to an electric streetfighter with instant torque.',
                    'accent_color' => '#2dd4bf',
                    'cover_image' => 'images/brands/volta.jpg',
                ],
                'motorcycles' => [
                    ['name' => 'Pulse E', 'category' => MotorcycleCategory::Scooter, 'price' => 14900, 'engine_cc' => null, 'power_hp' => 11, 'weight_kg' => 118, 'is_featured' => true, 'description' => 'A connected electric scooter with 140 km of range, app-based unlocking and a 3.5-hour home charge.'],
                    ['name' => 'Metro 125', 'category' => MotorcycleCategory::Scooter, 'price' => 9800, 'engine_cc' => 125, 'power_hp' => 12, 'weight_kg' => 124, 'is_featured' => false, 'description' => 'The frugal everyday runabout: under-seat storage for a full-face helmet and 2.1 L/100 km.'],
                    ['name' => 'Volt-R', 'category' => MotorcycleCategory::Naked, 'price' => 79000, 'engine_cc' => null, 'power_hp' => 100, 'weight_kg' => 251, 'is_featured' => true, 'description' => 'An all-electric streetfighter delivering 0–100 km/h in 3.0 seconds with zero tailpipe emissions.'],
                ],
                'promotion' => ['title' => 'Go Electric for Less', 'highlight' => '0% APR · 24 mo', 'description' => 'Ride away on any Volta electric model with zero-interest financing over 24 months and a free home wall-charger.'],
            ],
            [
                'brand' => [
                    'name' => 'Nomad',
                    'segment' => BrandSegment::AdventureTouring,
                    'tagline' => 'Built for the long way round.',
                    'description' => 'Nomad engineers adventure tourers for dunes, wadis and cross-border journeys — long-range tanks, heat-proof electronics and luggage-ready frames.',
                    'accent_color' => '#a8b545',
                    'cover_image' => 'images/brands/nomad.jpg',
                ],
                'motorcycles' => [
                    ['name' => 'Atlas 1250', 'category' => MotorcycleCategory::Adventure, 'price' => 98500, 'engine_cc' => 1254, 'power_hp' => 136, 'weight_kg' => 249, 'is_featured' => true, 'description' => 'The flagship continent-crosser with a 30 L tank, adaptive suspension and an off-road ABS mode tuned for sand.'],
                    ['name' => 'Ridge 800', 'category' => MotorcycleCategory::Adventure, 'price' => 58900, 'engine_cc' => 799, 'power_hp' => 95, 'weight_kg' => 229, 'is_featured' => false, 'description' => 'Middleweight balance of tarmac comfort and trail capability, with a 21-inch front wheel.'],
                    ['name' => 'Trail 450', 'category' => MotorcycleCategory::Adventure, 'price' => 27500, 'engine_cc' => 449, 'power_hp' => 42, 'weight_kg' => 158, 'is_featured' => false, 'description' => 'Light, forgiving and ready for your first desert crossing.'],
                ],
                'promotion' => ['title' => 'Desert Season Pack', 'highlight' => 'Free Touring Kit', 'description' => 'Aluminium panniers, crash bars and a sand-filter kit — worth QAR 6,500 — free with every Atlas 1250.'],
            ],
            [
                'brand' => [
                    'name' => 'Apex',
                    'segment' => BrandSegment::Performance,
                    'tagline' => 'Every tenth counts.',
                    'description' => 'Apex is our race-bred performance house: superbikes and streetfighters developed on track and homologated for the road.',
                    'accent_color' => '#f43f5e',
                    'cover_image' => 'images/brands/apex.jpg',
                ],
                'motorcycles' => [
                    ['name' => 'RR-1000', 'category' => MotorcycleCategory::Sport, 'price' => 112000, 'engine_cc' => 998, 'power_hp' => 208, 'weight_kg' => 196, 'is_featured' => true, 'description' => 'A 208 hp superbike with carbon winglets, cornering ABS and a launch-control system lifted from racing.'],
                    ['name' => 'Strike 600', 'category' => MotorcycleCategory::Sport, 'price' => 49900, 'engine_cc' => 599, 'power_hp' => 118, 'weight_kg' => 189, 'is_featured' => false, 'description' => 'A screaming 16,000 rpm supersport — the sharpest way to learn the track.'],
                    ['name' => 'Fury 890', 'category' => MotorcycleCategory::Naked, 'price' => 54500, 'engine_cc' => 889, 'power_hp' => 119, 'weight_kg' => 181, 'is_featured' => true, 'description' => 'A twin-cylinder hyper-naked with wheelie control and a quickshifter as standard.'],
                ],
                'promotion' => ['title' => 'Lusail Track Experience', 'highlight' => 'Free Track Day', 'description' => 'Buy any Apex before month-end and get a coached track day for two at Lusail International Circuit.'],
            ],
            [
                'brand' => [
                    'name' => 'Sovereign',
                    'segment' => BrandSegment::Premium,
                    'tagline' => 'Craft you can feel at idle.',
                    'description' => 'Sovereign hand-finishes grand cruisers and modern classics — deep paint, machined billet details and a concierge ownership programme.',
                    'accent_color' => '#d6b56d',
                    'cover_image' => 'images/brands/sovereign.jpg',
                ],
                'motorcycles' => [
                    ['name' => 'Imperial 1900', 'category' => MotorcycleCategory::Cruiser, 'price' => 129000, 'engine_cc' => 1868, 'power_hp' => 94, 'weight_kg' => 352, 'is_featured' => true, 'description' => 'Our grandest cruiser: 155 Nm of V-twin torque, hand-laid pinstripes and a bespoke leather saddle.'],
                    ['name' => 'Noir 1800', 'category' => MotorcycleCategory::Cruiser, 'price' => 96000, 'engine_cc' => 1753, 'power_hp' => 92, 'weight_kg' => 310, 'is_featured' => false, 'description' => 'A blacked-out power cruiser with a low 680 mm seat and a deep, rumbling exhaust note.'],
                    ['name' => 'Heritage 650', 'category' => MotorcycleCategory::Classic, 'price' => 26900, 'engine_cc' => 648, 'power_hp' => 47, 'weight_kg' => 214, 'is_featured' => false, 'description' => 'Timeless parallel-twin roadster — chrome, spoked wheels and a soundtrack from another era.'],
                ],
                'promotion' => ['title' => 'Sovereign Care', 'highlight' => '3-Year Service', 'description' => 'Three years of scheduled maintenance, roadside assistance and valet pick-up included with every new Sovereign.'],
            ],
        ];
    }
}
