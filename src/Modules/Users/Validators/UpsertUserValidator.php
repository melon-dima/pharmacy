<?php

namespace Src\Modules\Users\Validators;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Src\Modules\Users\DTO\UserData;

class UpsertUserValidator
{
    public function validateForCreate(Request $request): UserData
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        return UserData::fromValidated($validated);
    }

    public function validateForUpdate(Request $request, User $user): UserData
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        return UserData::fromValidated($validated);
    }
}
