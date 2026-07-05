<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // Cocok dengan kolom di migration tabel categories
    protected $fillable = [
        'user_id',
        'category_name',
        'monthly_limit',
        'category_type',
    ];

    // Pemilik kategori ini adalah User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Kategori ini bisa dipakai di banyak catatan pengeluaran
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    // Kategori ini bisa punya banyak tantangan
    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }
}