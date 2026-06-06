<?php

namespace Src\Modules\Inventory\Services;

use App\Models\PharmacyInventoryItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Inventory\Domain\Repositories\InventoryRepositoryInterface;
use Src\Modules\Inventory\Domain\Services\InventoryAccountingService;
use Src\Modules\Inventory\DTO\InventoryItemData;

class InventoryService
{
    public function __construct(
        private readonly InventoryRepositoryInterface $inventory,
        private readonly InventoryAccountingService $accounting,
    ) {
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->inventory->paginate($perPage);
    }

    public function loadForShow(PharmacyInventoryItem $item): PharmacyInventoryItem
    {
        return $this->inventory->loadForShow($item);
    }

    public function create(InventoryItemData $data): PharmacyInventoryItem
    {
        return $this->accounting->create($data);
    }

    public function update(PharmacyInventoryItem $item, InventoryItemData $data): PharmacyInventoryItem
    {
        return $this->accounting->update($item, $data);
    }

    /**
     * @return Collection<int, \App\Models\Pharmacy>
     */
    public function getFormPharmacies(): Collection
    {
        return $this->inventory->activePharmacies();
    }
}
