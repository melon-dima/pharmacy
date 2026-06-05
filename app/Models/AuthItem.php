<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuthItem extends Model
{
    protected $table = 'auth_item';

    protected $primaryKey = 'name';

    public $incrementing = false;

    protected $keyType = 'string';

    public const TYPE_ROLE = 1;

    public const TYPE_PERMISSION = 2;

    protected $fillable = ['name', 'type', 'description', 'rule_name', 'data'];

    protected function casts(): array
    {
        return [
            'type' => 'integer',
        ];
    }

    public function isRole(): bool
    {
        return (int) $this->type === self::TYPE_ROLE;
    }

    public function isPermission(): bool
    {
        return (int) $this->type === self::TYPE_PERMISSION;
    }

    /**
     * @return BelongsTo<AuthRule, $this>
     */
    public function rule(): BelongsTo
    {
        return $this->belongsTo(AuthRule::class, 'rule_name', 'name');
    }

    /**
     * @return HasMany<AuthAssignment, $this>
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(AuthAssignment::class, 'item_name', 'name');
    }

    /**
     * @return HasMany<AuthItemChild, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(AuthItemChild::class, 'parent', 'name');
    }

    /**
     * @return HasMany<AuthItemChild, $this>
     */
    public function parents(): HasMany
    {
        return $this->hasMany(AuthItemChild::class, 'child', 'name');
    }

    /**
     * @return BelongsToMany<AuthItem, $this>
     */
    public function childItems(): BelongsToMany
    {
        return $this->belongsToMany(AuthItem::class, 'auth_item_child', 'parent', 'child', 'name', 'name');
    }

    /**
     * @return Collection<int, static>
     */
    public static function getRoles(): Collection
    {
        return static::query()->where('type', self::TYPE_ROLE)->orderBy('name')->get();
    }

    /**
     * @return Collection<int, static>
     */
    public static function getPermissions(): Collection
    {
        return static::query()->where('type', self::TYPE_PERMISSION)->orderBy('name')->get();
    }
}

