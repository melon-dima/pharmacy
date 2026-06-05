<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeLog extends Model
{
    protected $fillable = ['system', 'direction', 'status', 'payload', 'response', 'exchanged_at'];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'exchanged_at' => 'datetime',
        ];
    }
}
