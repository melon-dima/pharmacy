<?php

namespace Src\Modules\Reports\DTO;

class QueueReportData
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly ?string $periodStart,
        public readonly ?string $periodEnd,
        public readonly ?int $generatedByUserId,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated): self
    {
        return new self(
            name: (string) $validated['name'],
            type: (string) $validated['type'],
            periodStart: isset($validated['period_start']) ? (string) $validated['period_start'] : null,
            periodEnd: isset($validated['period_end']) ? (string) $validated['period_end'] : null,
            generatedByUserId: isset($validated['generated_by_user_id']) ? (int) $validated['generated_by_user_id'] : null,
        );
    }
}
