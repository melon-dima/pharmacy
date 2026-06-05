<?php

namespace Src\Modules\Employees\DTO;

class EmployeeData
{
    public function __construct(
        public readonly ?int $userId,
        public readonly ?int $pharmacyId,
        public readonly string $fullName,
        public readonly ?string $position,
        public readonly ?string $phone,
        public readonly ?string $email,
        public readonly ?string $hiredAt,
        public readonly bool $isActive,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated, bool $isActive): self
    {
        return new self(
            userId: isset($validated['user_id']) ? (int) $validated['user_id'] : null,
            pharmacyId: isset($validated['pharmacy_id']) ? (int) $validated['pharmacy_id'] : null,
            fullName: (string) $validated['full_name'],
            position: isset($validated['position']) ? (string) $validated['position'] : null,
            phone: isset($validated['phone']) ? (string) $validated['phone'] : null,
            email: isset($validated['email']) ? (string) $validated['email'] : null,
            hiredAt: isset($validated['hired_at']) ? (string) $validated['hired_at'] : null,
            isActive: $isActive,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'pharmacy_id' => $this->pharmacyId,
            'full_name' => $this->fullName,
            'position' => $this->position,
            'phone' => $this->phone,
            'email' => $this->email,
            'hired_at' => $this->hiredAt,
            'is_active' => $this->isActive,
        ];
    }
}
