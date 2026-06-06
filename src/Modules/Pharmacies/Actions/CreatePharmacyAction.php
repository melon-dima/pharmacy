<?php

namespace Src\Modules\Pharmacies\Actions;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Src\Modules\Pharmacies\Domain\Exceptions\DuplicatePharmacyCode;
use Src\Modules\Pharmacies\Services\PharmacyService;
use Src\Modules\Pharmacies\Validators\UpsertPharmacyValidator;

class CreatePharmacyAction
{
    public function __construct(
        private readonly UpsertPharmacyValidator $validator,
        private readonly PharmacyService $service,
    ) {
    }

    public function handle(Request $request): Pharmacy
    {
        $data = $this->validator->validateForCreate($request);

        try {
            return $this->service->create($data);
        } catch (DuplicatePharmacyCode $exception) {
            throw ValidationException::withMessages([
                'code' => $exception->getMessage(),
            ]);
        }
    }
}
