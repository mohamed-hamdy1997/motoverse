<?php

namespace App\Policies;

use App\Models\Promotion;
use App\Models\User;

class PromotionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->managedBrandIds() !== [];
    }

    public function update(User $user, Promotion $promotion): bool
    {
        return $user->canManageBrand($promotion->brand_id);
    }

    public function delete(User $user, Promotion $promotion): bool
    {
        return $user->canManageBrand($promotion->brand_id);
    }
}
