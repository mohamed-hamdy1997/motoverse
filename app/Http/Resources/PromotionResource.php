<?php

namespace App\Http\Resources;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Promotion
 */
class PromotionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'title' => $this->title,
            'highlight' => $this->highlight,
            'description' => $this->description,
            'starts_at' => $this->starts_at->toDateString(),
            'ends_at' => $this->ends_at->toDateString(),
            'is_active' => $this->is_active,
            'is_running' => $this->is_active && today()->between($this->starts_at, $this->ends_at),
            'brand' => new BrandResource($this->whenLoaded('brand')),
        ];
    }
}
