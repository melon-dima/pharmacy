<?php

namespace Src\Modules\CustomerOrders\Domain\ValueObjects;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
