<?php

namespace Src\Modules\Analytics\DTO;

use Illuminate\Support\Carbon;

class AnalyticsEventData
{
    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        public readonly string $eventName,
        public readonly ?int $actorId,
        public readonly string $subjectType,
        public readonly ?int $subjectId,
        public readonly array $payload = [],
        public readonly ?Carbon $occurredAt = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toClickHouseRow(): array
    {
        return [
            'occurred_at' => ($this->occurredAt ?? Carbon::now())->format('Y-m-d H:i:s'),
            'event_name' => $this->eventName,
            'actor_id' => $this->actorId,
            'subject_type' => $this->subjectType,
            'subject_id' => $this->subjectId,
            'payload' => json_encode($this->payload, JSON_THROW_ON_ERROR),
        ];
    }
}
