<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PharmacyInventoryItem extends Model
{
    protected $fillable = [
        'pharmacy_id',
        'medicine_id',
        'quantity',
        'minimum_quantity',
        'expires_on',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'minimum_quantity' => 'integer',
            'expires_on' => 'date',
        ];
    }

    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->minimum_quantity;
    }
}
