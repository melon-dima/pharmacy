<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\Reports\Actions\GetReportFormOptionsAction;
use Src\Modules\Reports\Actions\ListReportsAction;
use Src\Modules\Reports\Actions\QueueReportGenerationAction;
use Src\Modules\Reports\Actions\ShowReportAction;
use Src\Modules\Reports\Actions\UpdateReportAction;

class ReportController extends Controller
{
    public function __construct(
        private readonly ListReportsAction $listReportsAction,
        private readonly ShowReportAction $showReportAction,
        private readonly GetReportFormOptionsAction $getReportFormOptionsAction,
        private readonly QueueReportGenerationAction $queueReportGenerationAction,
        private readonly UpdateReportAction $updateReportAction,
    ) {
    }

    public function index(): View
    {
        $reports = $this->listReportsAction->handle(20);

        return view('portal.reports.index', compact('reports'));
    }

    public function show(Report $report): View
    {
        $report = $this->showReportAction->handle($report);

        return view('portal.reports.show', compact('report'));
    }

    public function create(): View
    {
        $users = $this->getReportFormOptionsAction->handle();

        return view('portal.reports.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->queueReportGenerationAction->handle($request);

        return redirect()->route('reports.index');
    }

    public function edit(Report $report): View
    {
        $users = $this->getReportFormOptionsAction->handle();

        return view('portal.reports.edit', compact('report', 'users'));
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        $this->updateReportAction->handle($request, $report);

        return redirect()->route('reports.index');
    }
}
