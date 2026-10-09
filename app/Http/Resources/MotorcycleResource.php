<?php

namespace App\Http\Resources;

use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Motorcycle
 */
class MotorcycleResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category' => $this->category->value,
            'category_label' => $this->category->label(),
            'price' => (float) $this->price,
            'engine_cc' => $this->engine_cc,
            'is_electric' => $this->isElectric(),
            'power_hp' => $this->power_hp,
            'weight_kg' => $this->weight_kg,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'is_featured' => $this->is_featured,
            'is_published' => $this->is_published,
            'brand' => new BrandResource($this->whenLoaded('brand')),
        ];
    }
}
