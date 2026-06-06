<?php

namespace Tests\Feature\Modules\Medicines;

use App\Models\Medicine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicineManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_medicine_for_catalog(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('medicines.store'), [
                'name' => 'Aspirin',
                'sku' => ' med-001 ',
                'manufacturer' => 'Acme',
                'description' => 'Pain relief',
                'dosage_form' => 'tablets',
                'unit' => 'pack',
                'price' => '123.45',
                'currency' => 'rub',
                'is_active' => '1',
                'external_system' => '1C',
                'external_id' => '0001',
            ]);

        $response->assertRedirect(route('medicines.index'));
        $this->assertDatabaseHas('medicines', [
            'name' => 'Aspirin',
            'sku' => 'MED-001',
            'price_cents' => 12345,
            'currency' => 'RUB',
            'external_system' => '1c',
            'external_id' => '0001',
            'is_active' => true,
        ]);
    }

    public function test_authenticated_user_can_deactivate_medicine_instead_of_deleting_it(): void
    {
        $user = User::factory()->create();
        $medicine = Medicine::query()->create([
            'name' => 'Aspirin',
            'sku' => 'MED-001',
            'unit' => 'pack',
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('medicines.destroy', $medicine));

        $response->assertRedirect(route('medicines.index'));
        $this->assertDatabaseHas('medicines', [
            'id' => $medicine->id,
            'is_active' => false,
        ]);
    }
}
