<?php

namespace Src\Modules\Inventory\Actions;

use App\Models\PharmacyInventoryItem;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Src\Modules\Inventory\Domain\Exceptions\CannotTrackInactiveMedicine;
use Src\Modules\Inventory\Domain\Exceptions\CannotTrackInactivePharmacy;
use Src\Modules\Inventory\Domain\Exceptions\DuplicateInventoryItem;
use Src\Modules\Inventory\Services\InventoryService;
use Src\Modules\Inventory\Validators\UpsertInventoryItemValidator;

class CreateInventoryItemAction
{
    public function __construct(
        private readonly UpsertInventoryItemValidator $validator,
        private readonly InventoryService $service,
    ) {
    }

    public function handle(Request $request): PharmacyInventoryItem
    {
        $data = $this->validator->validate($request);

        try {
            return $this->service->create($data);
        } catch (CannotTrackInactivePharmacy $exception) {
            throw ValidationException::withMessages(['pharmacy_id' => $exception->getMessage()]);
        } catch (CannotTrackInactiveMedicine|DuplicateInventoryItem $exception) {
            throw ValidationException::withMessages(['medicine_name' => $exception->getMessage()]);
        }
    }
}
