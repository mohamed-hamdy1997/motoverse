<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;

class BrandPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Data-entry users may edit the profile of the brands they are assigned to.
     */
    public function update(User $user, Brand $brand): bool
    {
        return $user->canManageBrand($brand->id);
    }

    public function delete(User $user, Brand $brand): bool
    {
        return $user->isAdmin();
    }
}
