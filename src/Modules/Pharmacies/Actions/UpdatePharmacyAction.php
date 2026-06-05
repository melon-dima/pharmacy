<?php

namespace Src\Modules\Pharmacies\Actions;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
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

        return $this->service->update($pharmacy, $data);
    }
}
