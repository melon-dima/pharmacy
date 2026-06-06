<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerOrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'delivery_type' => $this->delivery_type,
            'status' => $this->status,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'delivery_address' => $this->delivery_address,
            'comment' => $this->comment,
            'pharmacy' => $this->whenLoaded('pharmacy', fn (): ?array => $this->pharmacy === null ? null : [
                'id' => $this->pharmacy->id,
                'name' => $this->pharmacy->name,
                'address' => $this->pharmacy->address,
                'phone' => $this->pharmacy->phone,
            ]),
            'items' => $this->whenLoaded('items', fn () => $this->items->map(fn ($item): array => [
                'id' => $item->id,
                'medicine_id' => $item->medicine_id,
                'medicine_name' => $item->medicine_name,
                'medicine_sku' => $item->medicine_sku,
                'quantity' => $item->quantity,
            ])->values()),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
