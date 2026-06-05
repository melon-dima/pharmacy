<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthItemChild extends Model
{
    protected $table = 'auth_item_child';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = ['parent', 'child'];

    /**
     * @return BelongsTo<AuthItem, $this>
     */
    public function parentItem(): BelongsTo
    {
        return $this->belongsTo(AuthItem::class, 'parent', 'name');
    }

    /**
     * @return BelongsTo<AuthItem, $this>
     */
    public function childItem(): BelongsTo
    {
        return $this->belongsTo(AuthItem::class, 'child', 'name');
    }
}

