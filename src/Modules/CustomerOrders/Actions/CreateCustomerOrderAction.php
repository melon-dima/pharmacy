<?php

namespace Src\Modules\CustomerOrders\Actions;

use App\Models\CustomerOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Src\Modules\CustomerOrders\Domain\Exceptions\CannotOrderInactivePharmacy;
use Src\Modules\CustomerOrders\Domain\Exceptions\EmptyCustomerOrder;
use Src\Modules\CustomerOrders\Domain\Exceptions\MedicineUnavailableForPickup;
use Src\Modules\CustomerOrders\Domain\Exceptions\MissingDeliveryAddress;
use Src\Modules\CustomerOrders\Domain\Exceptions\MissingPickupPharmacy;
use Src\Modules\CustomerOrders\Services\CustomerOrderService;
use Src\Modules\CustomerOrders\Validators\CreateCustomerOrderValidator;

class CreateCustomerOrderAction
{
    public function __construct(
        private readonly CreateCustomerOrderValidator $validator,
        private readonly CustomerOrderService $service,
    ) {
    }

    public function handle(Request $request, User $user): CustomerOrder
    {
        $data = $this->validator->validate($request);

        try {
            return $this->service->create($user, $data);
        } catch (MissingPickupPharmacy|CannotOrderInactivePharmacy $exception) {
            throw ValidationException::withMessages(['pharmacy_id' => $exception->getMessage()]);
        } catch (MissingDeliveryAddress $exception) {
            throw ValidationException::withMessages(['delivery_address' => $exception->getMessage()]);
        } catch (EmptyCustomerOrder|MedicineUnavailableForPickup $exception) {
            throw ValidationException::withMessages(['items' => $exception->getMessage()]);
        }
    }
}
