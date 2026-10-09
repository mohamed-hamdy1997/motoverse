<?php

namespace App\Models;

use Database\Factories\ShowroomFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'city', 'country', 'address', 'phone', 'opening_hours', 'has_service_center'])]
class Showroom extends Model
{
    /** @use HasFactory<ShowroomFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'has_service_center' => 'boolean',
        ];
    }
}
