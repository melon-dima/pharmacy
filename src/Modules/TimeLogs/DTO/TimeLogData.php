<?php

namespace Src\Modules\TimeLogs\DTO;

class TimeLogData
{
    /**
     * @param array<string, mixed>|null $meta
     */
    public function __construct(
        public readonly int $employeeId,
        public readonly ?int $shiftId,
        public readonly string $loggedAt,
        public readonly string $type,
        public readonly ?string $source,
        public readonly ?array $meta,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated): self
    {
        $meta = null;

        if (! empty($validated['meta'])) {
            $meta = json_decode((string) $validated['meta'], true);
        }

        return new self(
            employeeId: (int) $validated['employee_id'],
            shiftId: isset($validated['shift_id']) ? (int) $validated['shift_id'] : null,
            loggedAt: (string) $validated['logged_at'],
            type: (string) $validated['type'],
            source: isset($validated['source']) ? (string) $validated['source'] : null,
            meta: is_array($meta) ? $meta : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'employee_id' => $this->employeeId,
            'shift_id' => $this->shiftId,
            'logged_at' => $this->loggedAt,
            'type' => $this->type,
            'source' => $this->source,
            'meta' => $this->meta,
        ];
    }
}
