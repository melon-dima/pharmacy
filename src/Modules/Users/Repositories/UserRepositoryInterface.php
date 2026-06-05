<?php

namespace Src\Modules\Users\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator;

    public function loadForShow(User $user): User;

    /**
     * @param array<string, mixed> $attributes
     */
    public function create(array $attributes): User;

    /**
     * @param array<string, mixed> $attributes
     */
    public function update(User $user, array $attributes): User;
}
