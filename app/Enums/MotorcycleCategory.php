<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum MotorcycleCategory: string
{
    use HasOptions;

    case Scooter = 'scooter';
    case Naked = 'naked';
    case Adventure = 'adventure';
    case Sport = 'sport';
    case Cruiser = 'cruiser';
    case Classic = 'classic';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
