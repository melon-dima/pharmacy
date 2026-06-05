<?php

namespace Src\Modules\Checklists\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Checklists\Services\ChecklistService;

class ListChecklistsAction
{
    public function __construct(
        private readonly ChecklistService $service,
    ) {
    }

    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return $this->service->paginate($perPage);
    }
}
