<?php

namespace App\Models;

use App\Enums\EnquiryStatus;
use App\Enums\EnquiryType;
use App\Models\Concerns\BelongsToBrand;
use Database\Factories\EnquiryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['type', 'status', 'brand_id', 'motorcycle_id', 'showroom_id', 'name', 'email', 'phone', 'preferred_date', 'message'])]
class Enquiry extends Model
{
    /** @use HasFactory<EnquiryFactory> */
    use BelongsToBrand, HasFactory;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => EnquiryStatus::New->value,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => EnquiryType::class,
            'status' => EnquiryStatus::class,
            'preferred_date' => 'date',
        ];
    }

    /**
     * @return BelongsTo<Motorcycle, $this>
     */
    public function motorcycle(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class);
    }

    /**
     * @return BelongsTo<Showroom, $this>
     */
    public function showroom(): BelongsTo
    {
        return $this->belongsTo(Showroom::class);
    }
}
