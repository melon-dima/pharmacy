<?php

namespace Src\Modules\Users\Actions;

use App\Models\User;
use Src\Modules\Users\Services\UserService;

class ShowUserAction
{
    public function __construct(
        private readonly UserService $service,
    ) {
    }

    public function handle(User $user): User
    {
        return $this->service->loadForShow($user);
    }
}
