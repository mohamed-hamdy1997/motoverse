<?php

namespace App\Services;

use App\Models\Promotion;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PromotionService
{
    /**
     * @param  array{search?: string|null, brand_id?: int|string|null}  $filters
     * @return LengthAwarePaginator<int, Promotion>
     */
    public function paginateFor(User $user, array $filters, int $perPage = 10): LengthAwarePaginator
    {
        return Promotion::query()
            ->manageableBy($user)
            ->with('brand:id,name,accent_color')
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->whereLike('title', "%{$search}%"))
            ->when($filters['brand_id'] ?? null, fn ($query, $brandId) => $query->where('brand_id', $brandId))
            ->latest('ends_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Promotion
    {
        return Promotion::query()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Promotion $promotion, array $data): Promotion
    {
        $promotion->update($data);

        return $promotion;
    }

    public function delete(Promotion $promotion): void
    {
        $promotion->delete();
    }
}
