<?php

namespace App\Models\Concerns;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Shared behaviour for content that is owned by a brand and therefore
 * restricted to the users assigned to that brand.
 */
trait BelongsToBrand
{
    /**
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Limit the query to records the given user is allowed to manage.
     */
    #[Scope]
    protected function manageableBy(Builder $query, User $user): void
    {
        if ($user->isAdmin()) {
            return;
        }

        $query->whereIn($this->qualifyColumn('brand_id'), $user->managedBrandIds());
    }
}
