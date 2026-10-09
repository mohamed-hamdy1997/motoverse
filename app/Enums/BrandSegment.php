<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum BrandSegment: string
{
    use HasOptions;

    case UrbanMobility = 'urban_mobility';
    case AdventureTouring = 'adventure_touring';
    case Performance = 'performance';
    case Premium = 'premium';

    public function label(): string
    {
        return match ($this) {
            self::UrbanMobility => 'Urban Mobility',
            self::AdventureTouring => 'Adventure & Touring',
            self::Performance => 'Performance',
            self::Premium => 'Premium',
        };
    }
}
