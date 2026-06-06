<?php

namespace Src\Modules\Medicines\Actions;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Src\Modules\Medicines\Domain\Exceptions\DuplicateMedicineExternalIdentity;
use Src\Modules\Medicines\Domain\Exceptions\DuplicateMedicineSku;
use Src\Modules\Medicines\Services\MedicineService;
use Src\Modules\Medicines\Validators\UpsertMedicineValidator;

class CreateMedicineAction
{
    public function __construct(
        private readonly UpsertMedicineValidator $validator,
        private readonly MedicineService $service,
    ) {
    }

    public function handle(Request $request): Medicine
    {
        $data = $this->validator->validate($request);

        try {
            return $this->service->create($data);
        } catch (DuplicateMedicineSku $exception) {
            throw ValidationException::withMessages(['sku' => $exception->getMessage()]);
        } catch (DuplicateMedicineExternalIdentity $exception) {
            throw ValidationException::withMessages(['external_id' => $exception->getMessage()]);
        }
    }
}
