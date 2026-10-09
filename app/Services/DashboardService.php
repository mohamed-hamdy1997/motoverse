<?php

namespace App\Services;

use App\Enums\EnquiryStatus;
use App\Models\Brand;
use App\Models\Enquiry;
use App\Models\Motorcycle;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class DashboardService
{
    /**
     * Headline figures scoped to the brands the user manages.
     *
     * @return array{motorcycles: int, promotions: int, new_enquiries: int, brands: int}
     */
    public function statsFor(User $user): array
    {
        return [
            'brands' => count($user->managedBrandIds()),
            'motorcycles' => Motorcycle::query()->manageableBy($user)->count(),
            'promotions' => Promotion::query()->manageableBy($user)->running()->count(),
            'new_enquiries' => Enquiry::query()->manageableBy($user)->where('status', EnquiryStatus::New)->count(),
        ];
    }

    /**
     * @return Collection<int, Enquiry>
     */
    public function latestEnquiriesFor(User $user, int $limit = 6): Collection
    {
        return Enquiry::query()
            ->manageableBy($user)
            ->with(['brand:id,name,accent_color', 'motorcycle:id,name'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Per-brand content counts for the brands the user manages.
     *
     * @return Collection<int, Brand>
     */
    public function brandBreakdownFor(User $user): Collection
    {
        return Brand::query()
            ->whereKey($user->managedBrandIds())
            ->withCount([
                'motorcycles',
                'promotions' => fn ($query) => $query->running(),
            ])
            ->ordered()
            ->get(['id', 'name', 'segment', 'accent_color']);
    }
}
