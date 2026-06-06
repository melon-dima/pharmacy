<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\Medicines\Actions\CreateMedicineAction;
use Src\Modules\Medicines\Actions\DeactivateMedicineAction;
use Src\Modules\Medicines\Actions\ListMedicinesAction;
use Src\Modules\Medicines\Actions\ShowMedicineAction;
use Src\Modules\Medicines\Actions\UpdateMedicineAction;

class MedicineController extends Controller
{
    public function __construct(
        private readonly ListMedicinesAction $listMedicinesAction,
        private readonly ShowMedicineAction $showMedicineAction,
        private readonly CreateMedicineAction $createMedicineAction,
        private readonly UpdateMedicineAction $updateMedicineAction,
        private readonly DeactivateMedicineAction $deactivateMedicineAction,
    ) {
    }

    public function index(): View
    {
        $search = request()->string('search')->toString();
        $medicines = $this->listMedicinesAction->handle(20, $search);

        return view('portal.medicines.index', compact('medicines', 'search'));
    }

    public function show(Medicine $medicine): View
    {
        $medicine = $this->showMedicineAction->handle($medicine);

        return view('portal.medicines.show', compact('medicine'));
    }

    public function create(): View
    {
        return view('portal.medicines.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->createMedicineAction->handle($request);

        return redirect()->route('medicines.index');
    }

    public function edit(Medicine $medicine): View
    {
        return view('portal.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine): RedirectResponse
    {
        $this->updateMedicineAction->handle($request, $medicine);

        return redirect()->route('medicines.index');
    }

    public function destroy(Medicine $medicine): RedirectResponse
    {
        $this->deactivateMedicineAction->handle($medicine);

        return redirect()->route('medicines.index');
    }
}
