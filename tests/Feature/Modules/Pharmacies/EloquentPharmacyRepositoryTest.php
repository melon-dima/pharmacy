<?php

namespace Tests\Feature\Modules\Pharmacies;

use App\Models\Employee;
use App\Models\Pharmacy;
use App\Models\Shift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Src\Modules\Pharmacies\Infrastructure\Repositories\EloquentPharmacyRepository;
use Tests\TestCase;

class EloquentPharmacyRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentPharmacyRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new EloquentPharmacyRepository();
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_code_exists_finds_pharmacy_by_code(): void
    {
        Pharmacy::query()->create([
            'name' => 'Central Pharmacy',
            'code' => 'APT-001',
        ]);

        $this->assertTrue($this->repository->codeExists('APT-001'));
        $this->assertFalse($this->repository->codeExists('APT-404'));
    }

    public function test_code_exists_can_ignore_current_pharmacy(): void
    {
        $pharmacy = Pharmacy::query()->create([
            'name' => 'Central Pharmacy',
            'code' => 'APT-001',
        ]);

        $this->assertFalse($this->repository->codeExists('APT-001', $pharmacy->id));
        $this->assertTrue($this->repository->codeExists('APT-001', $pharmacy->id + 1));
    }

    public function test_has_active_employees_only_counts_active_employees_for_given_pharmacy(): void
    {
        $pharmacy = Pharmacy::query()->create(['name' => 'Central Pharmacy']);
        $otherPharmacy = Pharmacy::query()->create(['name' => 'Other Pharmacy']);

        Employee::query()->create([
            'pharmacy_id' => $pharmacy->id,
            'full_name' => 'Inactive Employee',
            'is_active' => false,
        ]);
        Employee::query()->create([
            'pharmacy_id' => $otherPharmacy->id,
            'full_name' => 'Other Active Employee',
            'is_active' => true,
        ]);

        $this->assertFalse($this->repository->hasActiveEmployees($pharmacy->id));

        Employee::query()->create([
            'pharmacy_id' => $pharmacy->id,
            'full_name' => 'Active Employee',
            'is_active' => true,
        ]);

        $this->assertTrue($this->repository->hasActiveEmployees($pharmacy->id));
    }

    public function test_has_future_shifts_only_counts_future_shifts_for_given_pharmacy(): void
    {
        Carbon::setTestNow(Carbon::parse('2026-06-06 12:00:00'));

        $pharmacy = Pharmacy::query()->create(['name' => 'Central Pharmacy']);
        $otherPharmacy = Pharmacy::query()->create(['name' => 'Other Pharmacy']);
        $employee = Employee::query()->create([
            'pharmacy_id' => $pharmacy->id,
            'full_name' => 'Employee One',
            'is_active' => true,
        ]);
        $otherEmployee = Employee::query()->create([
            'pharmacy_id' => $otherPharmacy->id,
            'full_name' => 'Employee Two',
            'is_active' => true,
        ]);

        Shift::query()->create([
            'employee_id' => $employee->id,
            'pharmacy_id' => $pharmacy->id,
            'starts_at' => '2026-06-05 09:00:00',
            'ends_at' => '2026-06-05 18:00:00',
        ]);
        Shift::query()->create([
            'employee_id' => $otherEmployee->id,
            'pharmacy_id' => $otherPharmacy->id,
            'starts_at' => '2026-06-07 09:00:00',
            'ends_at' => '2026-06-07 18:00:00',
        ]);

        $this->assertFalse($this->repository->hasFutureShifts($pharmacy->id));

        Shift::query()->create([
            'employee_id' => $employee->id,
            'pharmacy_id' => $pharmacy->id,
            'starts_at' => '2026-06-07 09:00:00',
            'ends_at' => '2026-06-07 18:00:00',
        ]);

        $this->assertTrue($this->repository->hasFutureShifts($pharmacy->id));
    }
}
