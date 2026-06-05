<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'type',
        'starts_on',
        'ends_on',
        'reason',
        'status',
        'approved_by_user_id',
        'decided_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_on' => 'date',
            'ends_on' => 'date',
            'decided_at' => 'datetime',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_user_id');
    }
}
