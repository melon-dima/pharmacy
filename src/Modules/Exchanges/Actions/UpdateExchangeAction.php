<?php

namespace Src\Modules\Exchanges\Actions;

use App\Models\ExchangeLog;
use Illuminate\Http\Request;
use Src\Modules\Exchanges\Services\ExchangeService;
use Src\Modules\Exchanges\Validators\UpsertExchangeValidator;

class UpdateExchangeAction
{
    public function __construct(
        private readonly UpsertExchangeValidator $validator,
        private readonly ExchangeService $service,
    ) {
    }

    public function handle(Request $request, ExchangeLog $exchange): ExchangeLog
    {
        $data = $this->validator->validate($request);

        return $this->service->update($exchange, $data);
    }
}
