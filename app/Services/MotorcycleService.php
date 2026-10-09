<?php

namespace App\Services;

use App\Models\Motorcycle;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

class MotorcycleService
{
    public function __construct(
        private readonly ImageUploadService $images,
        private readonly SlugService $slugs,
    ) {}

    /**
     * @param  array{search?: string|null, brand_id?: int|string|null}  $filters
     * @return LengthAwarePaginator<int, Motorcycle>
     */
    public function paginateFor(User $user, array $filters, int $perPage = 10): LengthAwarePaginator
    {
        return Motorcycle::query()
            ->manageableBy($user)
            ->with('brand:id,name,accent_color')
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->whereLike('name', "%{$search}%"))
            ->when($filters['brand_id'] ?? null, fn ($query, $brandId) => $query->where('brand_id', $brandId))
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data, ?UploadedFile $image): Motorcycle
    {
        return Motorcycle::query()->create([
            ...$data,
            'slug' => $this->slugs->unique(Motorcycle::class, $data['name']),
            'image' => $this->images->replace($image, null, 'motorcycles'),
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Motorcycle $motorcycle, array $data, ?UploadedFile $image): Motorcycle
    {
        $motorcycle->update([
            ...$data,
            'slug' => $this->slugs->unique(Motorcycle::class, $data['name'], $motorcycle->id),
            'image' => $this->images->replace($image, $motorcycle->image, 'motorcycles'),
        ]);

        return $motorcycle;
    }

    public function delete(Motorcycle $motorcycle): void
    {
        $this->images->delete($motorcycle->image);

        $motorcycle->delete();
    }
}
