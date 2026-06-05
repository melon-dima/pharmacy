<?php

namespace Src\Modules\Schedules\DTO;

class ScheduleData
{
    public function __construct(
        public readonly int $employeeId,
        public readonly int $pharmacyId,
        public readonly string $startsAt,
        public readonly string $endsAt,
        public readonly string $status,
        public readonly ?string $notes,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated): self
    {
        return new self(
            employeeId: (int) $validated['employee_id'],
            pharmacyId: (int) $validated['pharmacy_id'],
            startsAt: (string) $validated['starts_at'],
            endsAt: (string) $validated['ends_at'],
            status: (string) $validated['status'],
            notes: isset($validated['notes']) ? (string) $validated['notes'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'employee_id' => $this->employeeId,
            'pharmacy_id' => $this->pharmacyId,
            'starts_at' => $this->startsAt,
            'ends_at' => $this->endsAt,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }
}
