<?php

namespace Src\Modules\Users\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Users\Services\UserService;

class ListUsersAction
{
    public function __construct(
        private readonly UserService $service,
    ) {
    }

    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return $this->service->paginate($perPage);
    }
}
