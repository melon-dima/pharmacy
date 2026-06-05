<?php

namespace App\Services;

use App\Models\AuthAssignment;
use App\Models\AuthItem;
use App\Models\AuthItemChild;
use App\Models\User;

class RbacService
{
    public function hasPermission(User $user, string $permission): bool
    {
        if ($permission === '') {
            return false;
        }

        return in_array($permission, $this->getReachableItemNames($user), true);
    }

    public function hasRole(User $user, string $role): bool
    {
        if ($role === '') {
            return false;
        }

        if (! in_array($role, $this->getReachableItemNames($user), true)) {
            return false;
        }

        return AuthItem::query()
            ->whereKey($role)
            ->where('type', AuthItem::TYPE_ROLE)
            ->exists();
    }

    public function assignRole(User $user, string $role): void
    {
        $item = AuthItem::query()
            ->whereKey($role)
            ->where('type', AuthItem::TYPE_ROLE)
            ->firstOrFail();

        AuthAssignment::query()->firstOrCreate(
            [
                'user_id' => $user->getAuthIdentifier(),
                'item_name' => $item->getKey(),
            ],
            [
                'created_at' => now(),
            ]
        );
    }

    public function revokeRole(User $user, string $role): void
    {
        AuthAssignment::query()
            ->where('user_id', $user->getAuthIdentifier())
            ->where('item_name', $role)
            ->delete();
    }

    /**
     * @return array<int, string>
     */
    private function getReachableItemNames(User $user): array
    {
        $assigned = AuthAssignment::query()
            ->where('user_id', $user->getAuthIdentifier())
            ->pluck('item_name')
            ->all();

        if ($assigned === []) {
            return [];
        }

        $edges = AuthItemChild::query()
            ->select(['parent', 'child'])
            ->get()
            ->groupBy('parent')
            ->map(static fn ($items) => $items->pluck('child')->all())
            ->all();

        $stack = $assigned;
        $visited = [];

        while ($stack !== []) {
            $current = array_pop($stack);

            if (isset($visited[$current])) {
                continue;
            }

            $visited[$current] = true;

            foreach ($edges[$current] ?? [] as $child) {
                if (! isset($visited[$child])) {
                    $stack[] = $child;
                }
            }
        }

        return array_keys($visited);
    }
}
