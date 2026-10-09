<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * @return LengthAwarePaginator<int, User>
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return User::query()
            ->with('brands:id,name,accent_color')
            ->orderBy('role')
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::query()->create(Arr::except($data, ['brand_ids', 'password_confirmation']));
            $this->syncBrands($user, $data['brand_ids'] ?? []);

            return $user;
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $attributes = Arr::except($data, ['brand_ids', 'password_confirmation']);

            if (blank($attributes['password'] ?? null)) {
                unset($attributes['password']);
            }

            $user->update($attributes);
            $this->syncBrands($user, $data['brand_ids'] ?? []);

            return $user;
        });
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    /**
     * Admins see every brand implicitly, so explicit assignments only apply to data-entry users.
     *
     * @param  array<int, int>  $brandIds
     */
    private function syncBrands(User $user, array $brandIds): void
    {
        $user->brands()->sync($user->role === UserRole::DataEntry ? $brandIds : []);
    }
}
