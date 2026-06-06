<?php

namespace Src\Modules\CustomerOrders\Domain\ValueObjects;

enum DeliveryType: string
{
    case Pickup = 'pickup';
    case HomeDelivery = 'home_delivery';
}
