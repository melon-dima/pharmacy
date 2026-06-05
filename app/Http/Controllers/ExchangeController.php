<?php

namespace App\Http\Controllers;

use App\Models\ExchangeLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\Exchanges\Actions\CreateExchangeAction;
use Src\Modules\Exchanges\Actions\ListExchangesAction;
use Src\Modules\Exchanges\Actions\ShowExchangeAction;
use Src\Modules\Exchanges\Actions\UpdateExchangeAction;

class ExchangeController extends Controller
{
    public function __construct(
        private readonly ListExchangesAction $listExchangesAction,
        private readonly ShowExchangeAction $showExchangeAction,
        private readonly CreateExchangeAction $createExchangeAction,
        private readonly UpdateExchangeAction $updateExchangeAction,
    ) {
    }

    public function index(): View
    {
        $exchanges = $this->listExchangesAction->handle(20);

        return view('portal.exchange.index', compact('exchanges'));
    }

    public function show(ExchangeLog $exchange): View
    {
        $exchange = $this->showExchangeAction->handle($exchange);

        return view('portal.exchange.show', compact('exchange'));
    }

    public function create(): View
    {
        return view('portal.exchange.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->createExchangeAction->handle($request);

        return redirect()->route('exchange.index');
    }

    public function edit(ExchangeLog $exchange): View
    {
        return view('portal.exchange.edit', compact('exchange'));
    }

    public function update(Request $request, ExchangeLog $exchange): RedirectResponse
    {
        $this->updateExchangeAction->handle($request, $exchange);

        return redirect()->route('exchange.index');
    }
}
