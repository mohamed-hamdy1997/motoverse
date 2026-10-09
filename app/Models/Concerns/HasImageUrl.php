<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

/**
 * Resolves a stored image path to a public URL. Seeded demo images live in
 * `public/images`, while CMS uploads are stored on the "public" disk.
 */
trait HasImageUrl
{
    protected function resolveImageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return str_starts_with($path, 'images/')
            ? asset($path)
            : Storage::disk('public')->url($path);
    }
}
