<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuthRule extends Model
{
    protected $table = 'auth_rule';

    protected $primaryKey = 'name';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['name', 'data'];

    /**
     * @return HasMany<AuthItem, $this>
     */
    public function authItems(): HasMany
    {
        return $this->hasMany(AuthItem::class, 'rule_name', 'name');
    }
}

