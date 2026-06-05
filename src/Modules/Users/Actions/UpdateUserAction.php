<?php

namespace Src\Modules\Users\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Src\Modules\Users\Services\UserService;
use Src\Modules\Users\Validators\UpsertUserValidator;

class UpdateUserAction
{
    public function __construct(
        private readonly UpsertUserValidator $validator,
        private readonly UserService $service,
    ) {
    }

    public function handle(Request $request, User $user): User
    {
        $data = $this->validator->validateForUpdate($request, $user);

        return $this->service->update($user, $data);
    }
}
