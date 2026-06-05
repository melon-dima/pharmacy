<?php

namespace Src\Modules\Checklists\DTO;

class ChecklistData
{
    public function __construct(
        public readonly ?int $pharmacyId,
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $frequency,
        public readonly bool $isActive,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated, bool $isActive): self
    {
        return new self(
            pharmacyId: isset($validated['pharmacy_id']) ? (int) $validated['pharmacy_id'] : null,
            title: (string) $validated['title'],
            description: isset($validated['description']) ? (string) $validated['description'] : null,
            frequency: (string) $validated['frequency'],
            isActive: $isActive,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'pharmacy_id' => $this->pharmacyId,
            'title' => $this->title,
            'description' => $this->description,
            'frequency' => $this->frequency,
            'is_active' => $this->isActive,
        ];
    }
}
