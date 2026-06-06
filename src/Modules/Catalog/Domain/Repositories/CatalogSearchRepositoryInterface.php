<?php

namespace Src\Modules\Catalog\Domain\Repositories;

interface CatalogSearchRepositoryInterface
{
    /**
     * @return array<int, int>|null Null means the external search backend was unavailable.
     */
    public function searchMedicineIds(string $query, int $limit = 100): ?array;
}
