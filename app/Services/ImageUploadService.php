<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Stores CMS image uploads on the public disk and cleans up replaced files.
 */
class ImageUploadService
{
    private const string DISK = 'public';

    /**
     * Store a new upload, deleting the previous file when it is being replaced.
     */
    public function replace(?UploadedFile $file, ?string $currentPath, string $directory): ?string
    {
        if (! $file) {
            return $currentPath;
        }

        $this->delete($currentPath);

        return $file->store($directory, self::DISK);
    }

    /**
     * Seeded demo assets under `public/images` are never deleted.
     */
    public function delete(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'images/')) {
            Storage::disk(self::DISK)->delete($path);
        }
    }
}
