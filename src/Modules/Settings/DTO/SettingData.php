<?php

namespace Src\Modules\Settings\DTO;

class SettingData
{
    public function __construct(
        public readonly ?string $group,
        public readonly string $key,
        public readonly ?string $value,
        public readonly ?string $description,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated): self
    {
        return new self(
            group: isset($validated['group']) ? (string) $validated['group'] : null,
            key: (string) $validated['key'],
            value: isset($validated['value']) ? (string) $validated['value'] : null,
            description: isset($validated['description']) ? (string) $validated['description'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'group' => $this->group,
            'key' => $this->key,
            'value' => $this->value,
            'description' => $this->description,
        ];
    }
}
