<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MedicineResource;
use App\Http\Resources\Api\PharmacyResource;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Src\Modules\Catalog\Actions\ListCatalogMedicinesAction;
use Src\Modules\Catalog\Actions\ListCatalogPharmaciesAction;
use Src\Modules\Catalog\Actions\ShowCatalogMedicineAction;

class CatalogController extends Controller
{
    public function __construct(
        private readonly ListCatalogMedicinesAction $listCatalogMedicinesAction,
        private readonly ShowCatalogMedicineAction $showCatalogMedicineAction,
        private readonly ListCatalogPharmaciesAction $listCatalogPharmaciesAction,
    ) {
    }

    public function medicines(Request $request): AnonymousResourceCollection
    {
        return MedicineResource::collection(
            $this->listCatalogMedicinesAction->handle(20, $request->string('search')->toString())
        );
    }

    public function medicine(Medicine $medicine): MedicineResource
    {
        return MedicineResource::make($this->showCatalogMedicineAction->handle($medicine));
    }

    public function pharmacies(): AnonymousResourceCollection
    {
        return PharmacyResource::collection($this->listCatalogPharmaciesAction->handle());
    }
}
