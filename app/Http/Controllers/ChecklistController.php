<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\Checklists\Actions\CreateChecklistAction;
use Src\Modules\Checklists\Actions\GetChecklistFormOptionsAction;
use Src\Modules\Checklists\Actions\ListChecklistsAction;
use Src\Modules\Checklists\Actions\ShowChecklistAction;
use Src\Modules\Checklists\Actions\UpdateChecklistAction;

class ChecklistController extends Controller
{
    public function __construct(
        private readonly ListChecklistsAction $listChecklistsAction,
        private readonly ShowChecklistAction $showChecklistAction,
        private readonly GetChecklistFormOptionsAction $getChecklistFormOptionsAction,
        private readonly CreateChecklistAction $createChecklistAction,
        private readonly UpdateChecklistAction $updateChecklistAction,
    ) {
    }

    public function index(): View
    {
        $checklists = $this->listChecklistsAction->handle(20);

        return view('portal.checklists.index', compact('checklists'));
    }

    public function show(Checklist $checklist): View
    {
        $checklist = $this->showChecklistAction->handle($checklist);

        return view('portal.checklists.show', compact('checklist'));
    }

    public function create(): View
    {
        $pharmacies = $this->getChecklistFormOptionsAction->handle();

        return view('portal.checklists.create', compact('pharmacies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->createChecklistAction->handle($request);

        return redirect()->route('checklists.index');
    }

    public function edit(Checklist $checklist): View
    {
        $pharmacies = $this->getChecklistFormOptionsAction->handle();

        return view('portal.checklists.edit', compact('checklist', 'pharmacies'));
    }

    public function update(Request $request, Checklist $checklist): RedirectResponse
    {
        $this->updateChecklistAction->handle($request, $checklist);

        return redirect()->route('checklists.index');
    }
}
