<?php

namespace Src\Modules\Exchanges\Actions;

use App\Models\ExchangeLog;
use Src\Modules\Exchanges\Services\ExchangeService;

class ShowExchangeAction
{
    public function __construct(
        private readonly ExchangeService $service,
    ) {
    }

    public function handle(ExchangeLog $exchange): ExchangeLog
    {
        return $this->service->loadForShow($exchange);
    }
}
