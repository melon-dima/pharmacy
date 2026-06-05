<?php

namespace Src\Modules\Reports\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Reports\Services\ReportGenerationService;

class ListReportsAction
{
    public function __construct(
        private readonly ReportGenerationService $service,
    ) {
    }

    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return $this->service->paginate($perPage);
    }
}
