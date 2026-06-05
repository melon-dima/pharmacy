<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'pharmacy_id',
        'full_name',
        'position',
        'phone',
        'email',
        'hired_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'hired_at' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }

    public function timeLogs(): HasMany
    {
        return $this->hasMany(TimeLog::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(EmployeeRequest::class);
    }
}
