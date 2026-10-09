<?php

namespace App\Http\Resources;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Brand
 */
class BrandResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'segment' => $this->segment?->value,
            'segment_label' => $this->segment?->label(),
            'tagline' => $this->tagline,
            'description' => $this->description,
            'accent_color' => $this->accent_color,
            'cover_image_url' => $this->cover_image_url,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'motorcycles' => MotorcycleResource::collection($this->whenLoaded('motorcycles')),
            'motorcycles_count' => $this->whenCounted('motorcycles'),
            'promotions_count' => $this->whenCounted('promotions'),
        ];
    }
}
