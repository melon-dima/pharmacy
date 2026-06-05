<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\TimeLogs\Actions\CreateTimeLogAction;
use Src\Modules\TimeLogs\Actions\GetTimeLogFormOptionsAction;
use Src\Modules\TimeLogs\Actions\ListTimeLogsAction;
use Src\Modules\TimeLogs\Actions\ShowTimeLogAction;
use Src\Modules\TimeLogs\Actions\UpdateTimeLogAction;

class TimeLogController extends Controller
{
    public function __construct(
        private readonly ListTimeLogsAction $listTimeLogsAction,
        private readonly ShowTimeLogAction $showTimeLogAction,
        private readonly GetTimeLogFormOptionsAction $getTimeLogFormOptionsAction,
        private readonly CreateTimeLogAction $createTimeLogAction,
        private readonly UpdateTimeLogAction $updateTimeLogAction,
    ) {
    }

    public function index(): View
    {
        $timeLogs = $this->listTimeLogsAction->handle(30);

        return view('portal.timelog.index', compact('timeLogs'));
    }

    public function show(TimeLog $timelog): View
    {
        $timelog = $this->showTimeLogAction->handle($timelog);

        return view('portal.timelog.show', compact('timelog'));
    }

    public function create(): View
    {
        $options = $this->getTimeLogFormOptionsAction->handle();
        $employees = $options['employees'];
        $shifts = $options['shifts'];

        return view('portal.timelog.create', compact('employees', 'shifts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->createTimeLogAction->handle($request);

        return redirect()->route('timelog.index');
    }

    public function edit(TimeLog $timelog): View
    {
        $options = $this->getTimeLogFormOptionsAction->handle();
        $employees = $options['employees'];
        $shifts = $options['shifts'];

        return view('portal.timelog.edit', compact('timelog', 'employees', 'shifts'));
    }

    public function update(Request $request, TimeLog $timelog): RedirectResponse
    {
        $this->updateTimeLogAction->handle($request, $timelog);

        return redirect()->route('timelog.index');
    }
}
