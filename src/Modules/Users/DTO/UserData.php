<?php

namespace Src\Modules\Users\DTO;

class UserData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated): self
    {
        return new self(
            name: (string) $validated['name'],
            email: (string) $validated['email'],
            password: isset($validated['password']) && $validated['password'] !== ''
                ? (string) $validated['password']
                : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
