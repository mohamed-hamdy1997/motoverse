<?php

namespace App\Http\Resources;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Enquiry
 */
class EnquiryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type->value,
            'type_label' => $this->type->label(),
            'status' => $this->status->value,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'preferred_date' => $this->preferred_date?->toDateString(),
            'message' => $this->message,
            'created_at' => $this->created_at->toDateTimeString(),
            'created_at_human' => $this->created_at->diffForHumans(),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'motorcycle' => $this->whenLoaded('motorcycle', fn () => $this->motorcycle?->only('id', 'name')),
            'showroom' => $this->whenLoaded('showroom', fn () => $this->showroom?->only('id', 'name', 'city')),
        ];
    }
}
