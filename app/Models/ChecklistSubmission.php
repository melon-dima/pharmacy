<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistSubmission extends Model
{
    protected $fillable = [
        'checklist_id',
        'employee_id',
        'pharmacy_id',
        'submitted_at',
        'status',
        'overdue_minutes',
        'comments',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }

    public function checklist(): BelongsTo
    {
        return $this->belongsTo(Checklist::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
