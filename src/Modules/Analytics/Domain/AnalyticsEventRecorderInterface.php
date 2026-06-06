<?php

namespace Src\Modules\Analytics\Domain;

use Src\Modules\Analytics\DTO\AnalyticsEventData;

interface AnalyticsEventRecorderInterface
{
    public function record(AnalyticsEventData $event): void;
}
