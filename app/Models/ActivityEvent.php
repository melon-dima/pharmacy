<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityEvent extends Model
{
    protected $fillable = ['level', 'message', 'context', 'pharmacy_id', 'happened_at', 'meta'];

    protected function casts(): array
    {
        return [
            'happened_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
