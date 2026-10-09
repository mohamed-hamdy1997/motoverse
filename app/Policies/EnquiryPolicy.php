<?php

namespace App\Policies;

use App\Models\Enquiry;
use App\Models\User;

class EnquiryPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Enquiries without a brand (general questions) are visible to admins only.
     */
    public function update(User $user, Enquiry $enquiry): bool
    {
        return $user->canManageBrand($enquiry->brand_id);
    }

    public function delete(User $user, Enquiry $enquiry): bool
    {
        return $user->isAdmin();
    }
}
