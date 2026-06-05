<?php

namespace Src\Modules\Checklists\Actions;

use App\Models\Checklist;
use Src\Modules\Checklists\Services\ChecklistService;

class ShowChecklistAction
{
    public function __construct(
        private readonly ChecklistService $service,
    ) {
    }

    public function handle(Checklist $checklist): Checklist
    {
        return $this->service->loadForShow($checklist);
    }
}
