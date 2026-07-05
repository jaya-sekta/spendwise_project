<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Challenge extends Model
{
    // Cocok dengan kolom di migration tabel challenges
    protected $fillable = [
        'user_id',
        'category_id',
        'start_date',
        'end_date',
        'remaining_lives',
        'status',
    ];

    // Mengubah string tanggal di DB menjadi object Carbon/Date
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}