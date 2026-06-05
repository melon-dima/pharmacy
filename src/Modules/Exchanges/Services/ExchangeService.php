<?php

namespace Src\Modules\Exchanges\Services;

use App\Models\ExchangeLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Exchanges\DTO\ExchangeData;

class ExchangeService
{
    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return ExchangeLog::query()
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function loadForShow(ExchangeLog $exchange): ExchangeLog
    {
        return $exchange;
    }

    public function create(ExchangeData $data): ExchangeLog
    {
        return ExchangeLog::query()->create($data->toArray());
    }

    public function update(ExchangeLog $exchange, ExchangeData $data): ExchangeLog
    {
        $exchange->update($data->toArray());

        return $exchange;
    }
}
