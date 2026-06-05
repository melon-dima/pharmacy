<?php

namespace Src\Modules\Users\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator
    {
        return User::query()
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function loadForShow(User $user): User
    {
        return $user->load(['authAssignments.item', 'roles']);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function create(array $attributes): User
    {
        return User::query()->create($attributes);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function update(User $user, array $attributes): User
    {
        $user->update($attributes);

        return $user;
    }
}
