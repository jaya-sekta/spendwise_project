<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteLog extends Model
{
    const UPDATED_AT = null;

    protected $fillable = ['user_id', 'route_name', 'url', 'method'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Warna badge berdasarkan HTTP method
    public function getMethodColorAttribute(): string
    {
        return match ($this->method) {
            'GET'    => '#0EA5E9',
            'POST'   => '#10B981',
            'PUT', 'PATCH' => '#F59E0B',
            'DELETE' => '#EF4444',
            default  => '#64748B',
        };
    }
}