<?php

namespace Tests\Unit\Modules\CustomerOrders;

use App\Models\CustomerOrder;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\User;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Modules\CustomerOrders\Domain\Exceptions\MedicineUnavailableForPickup;
use Src\Modules\CustomerOrders\Domain\Exceptions\MissingDeliveryAddress;
use Src\Modules\CustomerOrders\Domain\Repositories\CustomerOrderRepositoryInterface;
use Src\Modules\CustomerOrders\Domain\Services\CustomerOrderPlacementService;
use Src\Modules\CustomerOrders\DTO\CreateCustomerOrderData;
use Src\Modules\CustomerOrders\DTO\CreateCustomerOrderItemData;

class CustomerOrderPlacementServiceTest extends TestCase
{
    private CustomerOrderRepositoryInterface&MockObject $repository;

    private CustomerOrderPlacementService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(CustomerOrderRepositoryInterface::class);
        $this->service = new CustomerOrderPlacementService($this->repository);
    }

    public function test_home_delivery_requires_delivery_address(): void
    {
        $data = new CreateCustomerOrderData(
            deliveryType: 'home_delivery',
            pharmacyId: null,
            customerName: 'Alice',
            customerPhone: '+100000000',
            deliveryAddress: null,
            comment: null,
            items: [new CreateCustomerOrderItemData(1, 2)],
        );

        $this->expectException(MissingDeliveryAddress::class);

        $this->service->place(new User(), $data);
    }

    public function test_pickup_requires_enough_quantity_in_selected_pharmacy(): void
    {
        $user = new User();
        $user->id = 3;
        $pharmacy = new Pharmacy(['is_active' => true]);
        $pharmacy->id = 5;
        $medicine = new Medicine([
            'name' => 'Aspirin',
            'sku' => 'MED-001',
            'is_active' => true,
            'price_cents' => 500,
            'currency' => 'RUB',
        ]);
        $medicine->id = 7;
        $data = new CreateCustomerOrderData(
            deliveryType: 'pickup',
            pharmacyId: 5,
            customerName: 'Alice',
            customerPhone: '+100000000',
            deliveryAddress: null,
            comment: null,
            items: [new CreateCustomerOrderItemData(7, 4)],
        );

        $this->repository
            ->method('findPharmacy')
            ->with(5)
            ->willReturn($pharmacy);

        $this->repository
            ->method('findMedicine')
            ->with(7)
            ->willReturn($medicine);

        $this->repository
            ->method('availableQuantity')
            ->with(5, 7)
            ->willReturn(2);

        $this->expectException(MedicineUnavailableForPickup::class);

        $this->service->place($user, $data);
    }

    public function test_pickup_order_is_created_when_quantity_is_available(): void
    {
        $user = new User();
        $user->id = 3;
        $pharmacy = new Pharmacy(['is_active' => true]);
        $pharmacy->id = 5;
        $medicine = new Medicine([
            'name' => 'Aspirin',
            'sku' => 'MED-001',
            'is_active' => true,
        ]);
        $medicine->id = 7;
        $order = new CustomerOrder();
        $data = new CreateCustomerOrderData(
            deliveryType: 'pickup',
            pharmacyId: 5,
            customerName: 'Alice',
            customerPhone: '+100000000',
            deliveryAddress: null,
            comment: 'Call me',
            items: [new CreateCustomerOrderItemData(7, 4)],
        );

        $this->repository
            ->method('findPharmacy')
            ->willReturn($pharmacy);

        $this->repository
            ->method('findMedicine')
            ->willReturn($medicine);

        $this->repository
            ->method('availableQuantity')
            ->willReturn(10);

        $this->repository
            ->expects($this->once())
            ->method('create')
            ->with(
                $this->identicalTo($user),
                [
                    'pharmacy_id' => 5,
                    'delivery_type' => 'pickup',
                    'status' => 'pending',
                    'customer_name' => 'Alice',
                    'customer_phone' => '+100000000',
                    'delivery_address' => null,
                    'total_cents' => 2000,
                    'currency' => 'RUB',
                    'comment' => 'Call me',
                ],
                [[
                    'medicine_id' => 7,
                    'medicine_name' => 'Aspirin',
                    'medicine_sku' => 'MED-001',
                    'quantity' => 4,
                    'unit_price_cents' => 500,
                    'currency' => 'RUB',
                ]],
            )
            ->willReturn($order);

        $this->assertSame($order, $this->service->place($user, $data));
    }
}
