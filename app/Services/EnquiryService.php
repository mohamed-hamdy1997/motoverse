<?php

namespace App\Services;

use App\Enums\EnquiryStatus;
use App\Models\Enquiry;
use App\Models\Motorcycle;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EnquiryService
{
    /**
     * Record a public enquiry. The brand is derived from the chosen model so
     * the enquiry is routed to that brand's data-entry team.
     *
     * @param  array<string, mixed>  $data
     */
    public function submit(array $data): Enquiry
    {
        $brandId = isset($data['motorcycle_id'])
            ? Motorcycle::query()->whereKey($data['motorcycle_id'])->value('brand_id')
            : null;

        return Enquiry::query()->create([
            ...$data,
            'brand_id' => $brandId,
            'status' => EnquiryStatus::New,
        ]);
    }

    /**
     * @param  array{status?: string|null, type?: string|null}  $filters
     * @return LengthAwarePaginator<int, Enquiry>
     */
    public function paginateFor(User $user, array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return Enquiry::query()
            ->manageableBy($user)
            ->with(['brand:id,name,accent_color', 'motorcycle:id,name', 'showroom:id,name,city'])
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($filters['type'] ?? null, fn ($query, $type) => $query->where('type', $type))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function updateStatus(Enquiry $enquiry, EnquiryStatus $status): Enquiry
    {
        $enquiry->update(['status' => $status]);

        return $enquiry;
    }

    public function delete(Enquiry $enquiry): void
    {
        $enquiry->delete();
    }
}
