<?php

namespace Src\Modules\Schedules\Actions;

use App\Models\Shift;
use Illuminate\Http\Request;
use Src\Modules\Schedules\Services\ScheduleService;
use Src\Modules\Schedules\Validators\UpsertScheduleValidator;

class CreateScheduleAction
{
    public function __construct(
        private readonly UpsertScheduleValidator $validator,
        private readonly ScheduleService $service,
    ) {
    }

    public function handle(Request $request): Shift
    {
        $data = $this->validator->validate($request);

        return $this->service->create($data);
    }
}
