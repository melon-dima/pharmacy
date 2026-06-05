<?php

namespace Src\Modules\Users\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Users\DTO\UserData;
use Src\Modules\Users\Repositories\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ) {
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function loadForShow(User $user): User
    {
        return $this->repository->loadForShow($user);
    }

    public function create(UserData $data): User
    {
        $payload = $data->toArray();
        if ($payload['password'] === null) {
            unset($payload['password']);
        }

        return $this->repository->create($payload);
    }

    public function update(User $user, UserData $data): User
    {
        $payload = $data->toArray();
        if ($payload['password'] === null) {
            unset($payload['password']);
        }

        return $this->repository->update($user, $payload);
    }
}
