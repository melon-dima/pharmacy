<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeLog extends Model
{
    protected $fillable = ['employee_id', 'shift_id', 'logged_at', 'type', 'source', 'meta'];

    protected function casts(): array
    {
        return [
            'logged_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }
}
