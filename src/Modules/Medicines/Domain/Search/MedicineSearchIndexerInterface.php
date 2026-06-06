<?php

namespace Src\Modules\Medicines\Domain\Search;

use App\Models\Medicine;

interface MedicineSearchIndexerInterface
{
    public function index(Medicine $medicine): void;

    public function remove(Medicine $medicine): void;
}
