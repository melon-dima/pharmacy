<?php

namespace Src\Modules\Users\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Src\Modules\Users\Services\UserService;
use Src\Modules\Users\Validators\UpsertUserValidator;

class CreateUserAction
{
    public function __construct(
        private readonly UpsertUserValidator $validator,
        private readonly UserService $service,
    ) {
    }

    public function handle(Request $request): User
    {
        $data = $this->validator->validateForCreate($request);

        return $this->service->create($data);
    }
}
