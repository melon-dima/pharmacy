<?php

namespace Database\Seeders;

use App\Models\AuthAssignment;
use App\Models\AuthItem;
use App\Models\AuthItemChild;
use App\Models\User;
use Illuminate\Database\Seeder;

class RbacSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        AuthItem::query()->updateOrCreate(
            ['name' => 'admin'],
            [
                'type' => AuthItem::TYPE_ROLE,
                'description' => 'System administrator',
            ]
        );

        AuthItem::query()->updateOrCreate(
            ['name' => 'dashboard.view'],
            [
                'type' => AuthItem::TYPE_PERMISSION,
                'description' => 'View dashboard',
            ]
        );

        AuthItemChild::query()->updateOrCreate(
            ['parent' => 'admin', 'child' => 'dashboard.view'],
            ['parent' => 'admin', 'child' => 'dashboard.view']
        );

        $firstUser = User::query()->oldest('id')->first();

        if ($firstUser === null) {
            return;
        }

        AuthAssignment::query()->firstOrCreate(
            ['item_name' => 'admin', 'user_id' => $firstUser->id],
            ['created_at' => now()]
        );
    }
}
