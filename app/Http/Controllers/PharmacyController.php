<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\Pharmacies\Actions\CreatePharmacyAction;
use Src\Modules\Pharmacies\Actions\ListPharmaciesAction;
use Src\Modules\Pharmacies\Actions\ShowPharmacyAction;
use Src\Modules\Pharmacies\Actions\UpdatePharmacyAction;

class PharmacyController extends Controller
{
    public function __construct(
        private readonly ListPharmaciesAction $listPharmaciesAction,
        private readonly ShowPharmacyAction $showPharmacyAction,
        private readonly CreatePharmacyAction $createPharmacyAction,
        private readonly UpdatePharmacyAction $updatePharmacyAction,
    ) {
    }

    public function index(): View
    {
        $pharmacies = $this->listPharmaciesAction->handle(20);

        return view('portal.pharmacies.index', compact('pharmacies'));
    }

    public function show(Pharmacy $pharmacy): View
    {
        $pharmacy = $this->showPharmacyAction->handle($pharmacy);

        return view('portal.pharmacies.show', compact('pharmacy'));
    }

    public function create(): View
    {
        return view('portal.pharmacies.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->createPharmacyAction->handle($request);

        return redirect()->route('pharmacies.index');
    }

    public function edit(Pharmacy $pharmacy): View
    {
        return view('portal.pharmacies.edit', compact('pharmacy'));
    }

    public function update(Request $request, Pharmacy $pharmacy): RedirectResponse
    {
        $this->updatePharmacyAction->handle($request, $pharmacy);

        return redirect()->route('pharmacies.index');
    }
}
