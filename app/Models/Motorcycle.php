<?php

namespace App\Models;

use App\Enums\MotorcycleCategory;
use App\Models\Concerns\BelongsToBrand;
use App\Models\Concerns\HasImageUrl;
use Database\Factories\MotorcycleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['brand_id', 'name', 'slug', 'category', 'price', 'engine_cc', 'power_hp', 'weight_kg', 'image', 'description', 'is_featured', 'is_published'])]
class Motorcycle extends Model
{
    /** @use HasFactory<MotorcycleFactory> */
    use BelongsToBrand, HasFactory, HasImageUrl;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => MotorcycleCategory::class,
            'price' => 'decimal:2',
            'engine_cc' => 'integer',
            'power_hp' => 'integer',
            'weight_kg' => 'integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function isElectric(): bool
    {
        return $this->engine_cc === null;
    }

    /**
     * @return Attribute<string|null, never>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->resolveImageUrl($this->image));
    }
}
