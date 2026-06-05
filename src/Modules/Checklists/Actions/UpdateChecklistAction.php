<?php

namespace Src\Modules\Checklists\Actions;

use App\Models\Checklist;
use Illuminate\Http\Request;
use Src\Modules\Checklists\Services\ChecklistService;
use Src\Modules\Checklists\Validators\UpsertChecklistValidator;

class UpdateChecklistAction
{
    public function __construct(
        private readonly UpsertChecklistValidator $validator,
        private readonly ChecklistService $service,
    ) {
    }

    public function handle(Request $request, Checklist $checklist): Checklist
    {
        $data = $this->validator->validate($request);

        return $this->service->update($checklist, $data);
    }
}
