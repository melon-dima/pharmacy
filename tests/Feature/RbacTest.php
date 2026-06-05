<?php

namespace Tests\Feature;

use App\Models\AuthAssignment;
use App\Models\AuthItem;
use App\Models\AuthItemChild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_gets_permission_through_assigned_role(): void
    {
        $user = User::factory()->create();

        AuthItem::query()->create([
            'name' => 'admin',
            'type' => AuthItem::TYPE_ROLE,
            'description' => 'Admin role',
        ]);

        AuthItem::query()->create([
            'name' => 'orders.manage',
            'type' => AuthItem::TYPE_PERMISSION,
            'description' => 'Manage orders',
        ]);

        AuthItemChild::query()->create([
            'parent' => 'admin',
            'child' => 'orders.manage',
        ]);

        AuthAssignment::query()->create([
            'item_name' => 'admin',
            'user_id' => $user->id,
            'created_at' => now(),
        ]);

        $this->assertTrue($user->hasRole('admin'));
        $this->assertTrue($user->hasPermission('orders.manage'));
        $this->assertTrue($user->can('orders.manage'));
        $this->assertFalse($user->hasPermission('orders.delete'));
    }
}
