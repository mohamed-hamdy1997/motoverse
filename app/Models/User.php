<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Memoized brand ids, so repeated permission checks within a request hit the database once.
     *
     * @var array<int, int>|null
     */
    private ?array $managedBrandIdsCache = null;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /**
     * Brands a data-entry user is assigned to.
     *
     * @return BelongsToMany<Brand, $this>
     */
    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    /**
     * Ids of every brand this user may manage (all brands for admins).
     *
     * @return array<int, int>
     */
    public function managedBrandIds(): array
    {
        return $this->managedBrandIdsCache ??= $this->isAdmin()
            ? Brand::query()->pluck('id')->all()
            : $this->brands()->pluck('brands.id')->all();
    }

    public function canManageBrand(?int $brandId): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $brandId !== null && in_array($brandId, $this->managedBrandIds(), true);
    }
}
