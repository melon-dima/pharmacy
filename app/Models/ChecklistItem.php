<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistItem extends Model
{
    protected $fillable = ['checklist_id', 'title', 'sort_order', 'is_required'];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
        ];
    }

    public function checklist(): BelongsTo
    {
        return $this->belongsTo(Checklist::class);
    }
}
