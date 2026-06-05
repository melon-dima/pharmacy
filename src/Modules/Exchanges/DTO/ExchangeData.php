<?php

namespace Src\Modules\Exchanges\DTO;

class ExchangeData
{
    /**
     * @param array<string, mixed>|null $payload
     */
    public function __construct(
        public readonly string $system,
        public readonly string $direction,
        public readonly string $status,
        public readonly ?array $payload,
        public readonly ?string $response,
        public readonly ?string $exchangedAt,
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
            system: (string) $validated['system'],
            direction: (string) $validated['direction'],
            status: (string) $validated['status'],
            payload: is_array($payload) ? $payload : null,
            response: isset($validated['response']) ? (string) $validated['response'] : null,
            exchangedAt: isset($validated['exchanged_at']) ? (string) $validated['exchanged_at'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'system' => $this->system,
            'direction' => $this->direction,
            'status' => $this->status,
            'payload' => $this->payload,
            'response' => $this->response,
            'exchanged_at' => $this->exchangedAt,
        ];
    }
}
