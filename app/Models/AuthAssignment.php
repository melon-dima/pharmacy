<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthAssignment extends Model
{
    protected $table = 'auth_assignment';

    protected $fillable = ['user_id', 'item_name'];

    public $timestamps = true;

    public const UPDATED_AT = null;

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<AuthItem, $this>
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(AuthItem::class, 'item_name', 'name');
    }
}

