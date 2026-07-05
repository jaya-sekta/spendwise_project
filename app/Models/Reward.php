<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reward extends Model
{
    // Cocok dengan kolom di migration tabel rewards
    protected $fillable = [
        'reward_name',
        'required_points',
        'stock',
    ];

    // 1 Reward di katalog bisa ditukarkan menjadi banyak UserReward
    public function userRewards(): HasMany
    {
        return $this->hasMany(UserReward::class);
    }
}