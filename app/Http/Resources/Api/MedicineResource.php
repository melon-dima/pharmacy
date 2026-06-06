<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'manufacturer' => $this->manufacturer,
            'description' => $this->description,
            'dosage_form' => $this->dosage_form,
            'unit' => $this->unit,
            'available_quantity' => (int) ($this->resource->relationLoaded('inventoryItems')
                ? $this->inventoryItems->sum('quantity')
                : ($this->available_quantity ?? 0)),
            'availability' => $this->whenLoaded('inventoryItems', fn () => $this->inventoryItems->map(fn ($item): array => [
                'pharmacy_id' => $item->pharmacy_id,
                'pharmacy_name' => $item->pharmacy?->name,
                'quantity' => $item->quantity,
                'minimum_quantity' => $item->minimum_quantity,
            ])->values()),
        ];
    }
}
