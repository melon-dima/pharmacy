<?php

namespace Src\Modules\Exchanges\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Exchanges\Services\ExchangeService;

class ListExchangesAction
{
    public function __construct(
        private readonly ExchangeService $service,
    ) {
    }

    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return $this->service->paginate($perPage);
    }
}
