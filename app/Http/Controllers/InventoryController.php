<?php

namespace App\Http\Controllers;

use App\Models\PharmacyInventoryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\Inventory\Actions\CreateInventoryItemAction;
use Src\Modules\Inventory\Actions\GetInventoryFormOptionsAction;
use Src\Modules\Inventory\Actions\ListInventoryItemsAction;
use Src\Modules\Inventory\Actions\ShowInventoryItemAction;
use Src\Modules\Inventory\Actions\UpdateInventoryItemAction;

class InventoryController extends Controller
{
    public function __construct(
        private readonly ListInventoryItemsAction $listInventoryItemsAction,
        private readonly ShowInventoryItemAction $showInventoryItemAction,
        private readonly GetInventoryFormOptionsAction $getInventoryFormOptionsAction,
        private readonly CreateInventoryItemAction $createInventoryItemAction,
        private readonly UpdateInventoryItemAction $updateInventoryItemAction,
    ) {
    }

    public function index(): View
    {
        $items = $this->listInventoryItemsAction->handle(30);

        return view('portal.inventory.index', compact('items'));
    }

    public function show(PharmacyInventoryItem $inventory): View
    {
        $item = $this->showInventoryItemAction->handle($inventory);

        return view('portal.inventory.show', compact('item'));
    }

    public function create(): View
    {
        $pharmacies = $this->getInventoryFormOptionsAction->handle();

        return view('portal.inventory.create', compact('pharmacies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->createInventoryItemAction->handle($request);

        return redirect()->route('inventory.index');
    }

    public function edit(PharmacyInventoryItem $inventory): View
    {
        $item = $inventory->load(['pharmacy', 'medicine']);
        $pharmacies = $this->getInventoryFormOptionsAction->handle();

        return view('portal.inventory.edit', compact('item', 'pharmacies'));
    }

    public function update(Request $request, PharmacyInventoryItem $inventory): RedirectResponse
    {
        $this->updateInventoryItemAction->handle($request, $inventory);

        return redirect()->route('inventory.index');
    }
}
