<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class BrandService
{
    public function __construct(
        private readonly ImageUploadService $images,
        private readonly SlugService $slugs,
    ) {}

    /**
     * @return Collection<int, Brand>
     */
    public function listFor(User $user): Collection
    {
        return Brand::query()
            ->when(! $user->isAdmin(), fn ($query) => $query->whereKey($user->managedBrandIds()))
            ->withCount(['motorcycles', 'promotions'])
            ->ordered()
            ->get();
    }

    /**
     * Lightweight id/name list used by brand pickers in admin forms.
     *
     * @return Collection<int, Brand>
     */
    public function optionsFor(User $user): Collection
    {
        return Brand::query()
            ->whereKey($user->managedBrandIds())
            ->ordered()
            ->get(['id', 'name', 'accent_color']);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data, ?UploadedFile $coverImage): Brand
    {
        return Brand::query()->create([
            ...$data,
            'slug' => $this->slugs->unique(Brand::class, $data['name']),
            'cover_image' => $this->images->replace($coverImage, null, 'brands'),
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Brand $brand, array $data, ?UploadedFile $coverImage): Brand
    {
        $brand->update([
            ...$data,
            'slug' => $this->slugs->unique(Brand::class, $data['name'], $brand->id),
            'cover_image' => $this->images->replace($coverImage, $brand->cover_image, 'brands'),
        ]);

        return $brand;
    }

    public function delete(Brand $brand): void
    {
        $brand->motorcycles()->pluck('image')->each(fn (?string $path) => $this->images->delete($path));
        $this->images->delete($brand->cover_image);

        $brand->delete();
    }
}
