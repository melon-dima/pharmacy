<?php

namespace Src\Modules\Reports\DTO;

class ReportData
{
    /**
     * @param array<string, mixed>|null $payload
     */
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly ?string $periodStart,
        public readonly ?string $periodEnd,
        public readonly ?array $payload,
        public readonly ?int $generatedByUserId,
        public readonly ?string $generatedAt,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated): self
    {
        $payload = null;

        if (! empty($validated['payload'])) {
            $payload = json_decode((string) $validated['payload'], true);
        }

        return new self(
            name: (string) $validated['name'],
            type: (string) $validated['type'],
            periodStart: isset($validated['period_start']) ? (string) $validated['period_start'] : null,
            periodEnd: isset($validated['period_end']) ? (string) $validated['period_end'] : null,
            payload: is_array($payload) ? $payload : null,
            generatedByUserId: isset($validated['generated_by_user_id']) ? (int) $validated['generated_by_user_id'] : null,
            generatedAt: isset($validated['generated_at']) ? (string) $validated['generated_at'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'period_start' => $this->periodStart,
            'period_end' => $this->periodEnd,
            'payload' => $this->payload,
            'generated_by_user_id' => $this->generatedByUserId,
            'generated_at' => $this->generatedAt,
        ];
    }
}
