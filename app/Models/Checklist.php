<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Checklist extends Model
{
    protected $fillable = ['pharmacy_id', 'title', 'description', 'frequency', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(ChecklistSubmission::class);
    }
}
