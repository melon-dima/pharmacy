<?php

namespace Src\Modules\EmployeeRequests\DTO;

class EmployeeRequestData
{
    public function __construct(
        public readonly int $employeeId,
        public readonly string $type,
        public readonly ?string $startsOn,
        public readonly ?string $endsOn,
        public readonly ?string $reason,
        public readonly string $status,
        public readonly ?int $approvedByUserId,
        public readonly ?string $decidedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated): self
    {
        return new self(
            employeeId: (int) $validated['employee_id'],
            type: (string) $validated['type'],
            startsOn: isset($validated['starts_on']) ? (string) $validated['starts_on'] : null,
            endsOn: isset($validated['ends_on']) ? (string) $validated['ends_on'] : null,
            reason: isset($validated['reason']) ? (string) $validated['reason'] : null,
            status: (string) $validated['status'],
            approvedByUserId: isset($validated['approved_by_user_id']) ? (int) $validated['approved_by_user_id'] : null,
            decidedAt: isset($validated['decided_at']) ? (string) $validated['decided_at'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'employee_id' => $this->employeeId,
            'type' => $this->type,
            'starts_on' => $this->startsOn,
            'ends_on' => $this->endsOn,
            'reason' => $this->reason,
            'status' => $this->status,
            'approved_by_user_id' => $this->approvedByUserId,
            'decided_at' => $this->decidedAt,
        ];
    }
}
