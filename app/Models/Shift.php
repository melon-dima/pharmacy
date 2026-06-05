<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shift extends Model
{
    protected $fillable = ['employee_id', 'pharmacy_id', 'starts_at', 'ends_at', 'status', 'notes'];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function timeLogs(): HasMany
    {
        return $this->hasMany(TimeLog::class);
    }
}
