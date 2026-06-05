<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Services\RbacService;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @return HasMany<AuthAssignment, $this>
     */
    public function authAssignments(): HasMany
    {
        return $this->hasMany(AuthAssignment::class, 'user_id');
    }

    /**
     * @return BelongsToMany<AuthItem, $this>
     */
    public function authItems(): BelongsToMany
    {
        return $this->belongsToMany(AuthItem::class, 'auth_assignment', 'user_id', 'item_name', 'id', 'name');
    }

    /**
     * @return BelongsToMany<Role, $this>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasPermission(string $permission): bool
    {
        return app(RbacService::class)->hasPermission($this, $permission);
    }

    public function hasRole(string $role): bool
    {
        return app(RbacService::class)->hasRole($this, $role);
    }

    public function assignRole(string $role): void
    {
        app(RbacService::class)->assignRole($this, $role);
    }

    public function revokeRole(string $role): void
    {
        app(RbacService::class)->revokeRole($this, $role);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
