<?php

namespace App\Services;

use App\Enums\EnquiryType;
use App\Models\Brand;
use App\Models\Promotion;
use App\Models\Showroom;
use Illuminate\Database\Eloquent\Collection;

/**
 * Collects everything the public homepage needs in a handful of queries.
 */
class HomePageService
{
    /**
     * @return Collection<int, Brand>
     */
    public function brands(): Collection
    {
        return Brand::query()
            ->active()
            ->ordered()
            ->with(['motorcycles' => fn ($query) => $query->published()->orderByDesc('is_featured')->orderBy('price')])
            ->get();
    }

    /**
     * @return Collection<int, Promotion>
     */
    public function runningPromotions(): Collection
    {
        return Promotion::query()
            ->running()
            ->whereHas('brand', fn ($query) => $query->active())
            ->with('brand')
            ->orderBy('ends_at')
            ->get();
    }

    /**
     * @return Collection<int, Showroom>
     */
    public function showrooms(): Collection
    {
        return Showroom::query()->orderBy('country')->orderBy('city')->get();
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public function enquiryTypes(): array
    {
        return EnquiryType::options();
    }
}
