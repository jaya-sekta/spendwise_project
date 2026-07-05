<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReward extends Model
{
    // Karena nama tabel jamak menggunakan underscore, definisikan secara eksplisit
    protected $table = 'user_rewards';

    // Cocok dengan kolom di migration tabel user_rewards
    protected $fillable = [
        'user_id',
        'reward_id',
        'redemption_date',
        'voucher_code',
    ];

    protected $casts = [
        'redemption_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class);
    }
}   