<?php

namespace Src\Modules\TimeLogs\Actions;

use App\Models\TimeLog;
use Illuminate\Http\Request;
use Src\Modules\TimeLogs\Services\TimeLogService;
use Src\Modules\TimeLogs\Validators\UpsertTimeLogValidator;

class UpdateTimeLogAction
{
    public function __construct(
        private readonly UpsertTimeLogValidator $validator,
        private readonly TimeLogService $service,
    ) {
    }

    public function handle(Request $request, TimeLog $timeLog): TimeLog
    {
        $data = $this->validator->validate($request);

        return $this->service->update($timeLog, $data);
    }
}
