<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum UserRole: string
{
    use HasOptions;

    case Admin = 'admin';
    case DataEntry = 'data_entry';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::DataEntry => 'Data Entry',
        };
    }
}
