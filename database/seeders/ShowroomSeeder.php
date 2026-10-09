<?php

namespace Database\Seeders;

use App\Models\Showroom;
use Illuminate\Database\Seeder;

class ShowroomSeeder extends Seeder
{
    public function run(): void
    {
        $showrooms = [
            ['name' => 'MotoVerse Flagship', 'city' => 'Doha', 'country' => 'Qatar', 'address' => 'Salwa Road, Al Aziziya', 'phone' => '+974 4400 1100', 'opening_hours' => 'Sat–Thu · 9:00–21:00', 'has_service_center' => true],
            ['name' => 'Lusail Boulevard Studio', 'city' => 'Lusail', 'country' => 'Qatar', 'address' => 'Lusail Boulevard, Tower 12', 'phone' => '+974 4400 1200', 'opening_hours' => 'Daily · 10:00–22:00', 'has_service_center' => false],
            ['name' => 'Industrial Area Service Hub', 'city' => 'Doha', 'country' => 'Qatar', 'address' => 'Street 24, Industrial Area', 'phone' => '+974 4400 1300', 'opening_hours' => 'Sat–Thu · 7:00–19:00', 'has_service_center' => true],
            ['name' => 'MotoVerse Dubai', 'city' => 'Dubai', 'country' => 'UAE', 'address' => 'Sheikh Zayed Road, Al Quoz 1', 'phone' => '+971 4 300 2200', 'opening_hours' => 'Mon–Sat · 9:00–21:00', 'has_service_center' => true],
            ['name' => 'MotoVerse Riyadh', 'city' => 'Riyadh', 'country' => 'Saudi Arabia', 'address' => 'King Fahd Road, Al Olaya', 'phone' => '+966 11 500 3300', 'opening_hours' => 'Sat–Thu · 10:00–22:00', 'has_service_center' => true],
            ['name' => 'MotoVerse Kuwait', 'city' => 'Kuwait City', 'country' => 'Kuwait', 'address' => 'Al Rai, Block 1', 'phone' => '+965 2200 4400', 'opening_hours' => 'Sat–Thu · 9:00–21:00', 'has_service_center' => false],
        ];

        foreach ($showrooms as $showroom) {
            Showroom::query()->create($showroom);
        }
    }
}
