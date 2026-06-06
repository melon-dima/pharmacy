<?php

namespace Src\Modules\Medicines\Domain\ValueObjects;

class MedicineExternalIdentity
{
    private readonly ?string $system;

    private readonly ?string $externalId;

    public function __construct(?string $system, ?string $externalId)
    {
        $system = $system === null ? null : strtolower(trim($system));
        $externalId = $externalId === null ? null : trim($externalId);

        if ($system === null || $externalId === null || $system === '' || $externalId === '') {
            $system = null;
            $externalId = null;
        }

        $this->system = $system;
        $this->externalId = $externalId;
    }

    public function system(): ?string
    {
        return $this->system;
    }

    public function externalId(): ?string
    {
        return $this->externalId;
    }
}
