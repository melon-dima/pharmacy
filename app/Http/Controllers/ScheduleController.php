<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\Schedules\Actions\CreateScheduleAction;
use Src\Modules\Schedules\Actions\GetScheduleFormOptionsAction;
use Src\Modules\Schedules\Actions\ListSchedulesAction;
use Src\Modules\Schedules\Actions\ShowScheduleAction;
use Src\Modules\Schedules\Actions\UpdateScheduleAction;

class ScheduleController extends Controller
{
    public function __construct(
        private readonly ListSchedulesAction $listSchedulesAction,
        private readonly ShowScheduleAction $showScheduleAction,
        private readonly GetScheduleFormOptionsAction $getScheduleFormOptionsAction,
        private readonly CreateScheduleAction $createScheduleAction,
        private readonly UpdateScheduleAction $updateScheduleAction,
    ) {
    }

    public function index(): View
    {
        $shifts = $this->listSchedulesAction->handle(20);

        return view('portal.schedules.index', compact('shifts'));
    }

    public function show(Shift $schedule): View
    {
        $schedule = $this->showScheduleAction->handle($schedule);

        return view('portal.schedules.show', [
            'shift' => $schedule,
        ]);
    }

    public function create(): View
    {
        $options = $this->getScheduleFormOptionsAction->handle();
        $employees = $options['employees'];
        $pharmacies = $options['pharmacies'];

        return view('portal.schedules.create', compact('employees', 'pharmacies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->createScheduleAction->handle($request);

        return redirect()->route('schedules.index');
    }

    public function edit(Shift $schedule): View
    {
        $options = $this->getScheduleFormOptionsAction->handle();
        $employees = $options['employees'];
        $pharmacies = $options['pharmacies'];

        return view('portal.schedules.edit', [
            'shift' => $schedule,
            'employees' => $employees,
            'pharmacies' => $pharmacies,
        ]);
    }

    public function update(Request $request, Shift $schedule): RedirectResponse
    {
        $this->updateScheduleAction->handle($request, $schedule);

        return redirect()->route('schedules.index');
    }
}
