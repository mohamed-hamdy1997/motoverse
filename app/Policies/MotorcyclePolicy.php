<?php

namespace App\Policies;

use App\Models\Motorcycle;
use App\Models\User;

class MotorcyclePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->managedBrandIds() !== [];
    }

    public function update(User $user, Motorcycle $motorcycle): bool
    {
        return $user->canManageBrand($motorcycle->brand_id);
    }

    public function delete(User $user, Motorcycle $motorcycle): bool
    {
        return $user->canManageBrand($motorcycle->brand_id);
    }
}
