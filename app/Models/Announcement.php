<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = ['title', 'body', 'level', 'is_published', 'starts_at', 'ends_at', 'created_by_user_id'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
