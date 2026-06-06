<?php

namespace Src\Modules\Pharmacies\Actions;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Src\Modules\Pharmacies\Domain\Exceptions\CannotDeactivatePharmacy;
use Src\Modules\Pharmacies\Domain\Exceptions\DuplicatePharmacyCode;
use Src\Modules\Pharmacies\Services\PharmacyService;
use Src\Modules\Pharmacies\Validators\UpsertPharmacyValidator;

class UpdatePharmacyAction
{
    public function __construct(
        private readonly UpsertPharmacyValidator $validator,
        private readonly PharmacyService $service,
    ) {
    }

    public function handle(Request $request, Pharmacy $pharmacy): Pharmacy
    {
        $data = $this->validator->validateForUpdate($request, $pharmacy);

        try {
            return $this->service->update($pharmacy, $data);
        } catch (DuplicatePharmacyCode $exception) {
            throw ValidationException::withMessages([
                'code' => $exception->getMessage(),
            ]);
        } catch (CannotDeactivatePharmacy $exception) {
            throw ValidationException::withMessages([
                'is_active' => $exception->getMessage(),
            ]);
        }
    }
}
