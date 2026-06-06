<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'manufacturer',
        'description',
        'dosage_form',
        'price_cents',
        'currency',
        'unit',
        'is_active',
        'external_system',
        'external_id',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'price_cents' => 'integer',
        ];
    }

    public function inventoryItems(): HasMany
    {
        return $this->hasMany(PharmacyInventoryItem::class);
    }
}
