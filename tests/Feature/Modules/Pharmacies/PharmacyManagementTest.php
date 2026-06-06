<?php

namespace Tests\Feature\Modules\Pharmacies;

use App\Models\Employee;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PharmacyManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_pharmacy_with_normalized_code(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('pharmacies.store'), [
                'name' => 'Central Pharmacy',
                'code' => ' apt-001 ',
                'address' => 'Main street',
                'phone' => '+100000000',
                'is_active' => '1',
            ]);

        $response->assertRedirect(route('pharmacies.index'));
        $this->assertDatabaseHas('pharmacies', [
            'name' => 'Central Pharmacy',
            'code' => 'APT-001',
            'is_active' => true,
        ]);
    }

    public function test_authenticated_user_cannot_create_pharmacy_with_duplicate_normalized_code(): void
    {
        $user = User::factory()->create();
        Pharmacy::query()->create([
            'name' => 'Central Pharmacy',
            'code' => 'APT-001',
        ]);

        $response = $this
            ->actingAs($user)
            ->from(route('pharmacies.create'))
            ->post(route('pharmacies.store'), [
                'name' => 'Duplicate Pharmacy',
                'code' => ' apt-001 ',
                'is_active' => '1',
            ]);

        $response
            ->assertRedirect(route('pharmacies.create'))
            ->assertSessionHasErrors('code');
        $this->assertDatabaseMissing('pharmacies', [
            'name' => 'Duplicate Pharmacy',
        ]);
    }

    public function test_authenticated_user_cannot_deactivate_pharmacy_with_active_employees(): void
    {
        $user = User::factory()->create();
        $pharmacy = Pharmacy::query()->create([
            'name' => 'Central Pharmacy',
            'code' => 'APT-001',
            'is_active' => true,
        ]);
        Employee::query()->create([
            'pharmacy_id' => $pharmacy->id,
            'full_name' => 'Active Employee',
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->from(route('pharmacies.edit', $pharmacy))
            ->put(route('pharmacies.update', $pharmacy), [
                'name' => 'Central Pharmacy',
                'code' => 'APT-001',
                'address' => null,
                'phone' => null,
                'is_active' => '0',
            ]);

        $response
            ->assertRedirect(route('pharmacies.edit', $pharmacy))
            ->assertSessionHasErrors('is_active');
        $this->assertDatabaseHas('pharmacies', [
            'id' => $pharmacy->id,
            'is_active' => true,
        ]);
    }
}
