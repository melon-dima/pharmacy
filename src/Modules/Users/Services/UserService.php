<?php

namespace Src\Modules\Users\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Users\DTO\UserData;

class UserService
{
    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->baseQuery()->paginate($perPage);
    }

    public function loadForShow(User $user): User
    {
        return $user->load(['authAssignments.item', 'roles']);
    }

    public function create(UserData $data): User
    {
        $payload = $data->toArray();
        if ($payload['password'] === null) {
            unset($payload['password']);
        }

        return User::query()->create($payload);
    }

    public function update(User $user, UserData $data): User
    {
        $payload = $data->toArray();
        if ($payload['password'] === null) {
            unset($payload['password']);
        }

        $user->update($payload);

        return $user;
    }

    private function baseQuery()
    {
        return User::query()->orderBy('name');
    }
}
