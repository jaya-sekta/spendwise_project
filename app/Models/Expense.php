<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    // Cocok dengan kolom di migration tabel expenses
    protected $fillable = [
        'user_id',
        'category_id',
        'expense_name',
        'amount',
        'expense_date',
        'is_over_limit',
    ];

    // Konversi tipe data otomatis dari database ke PHP object
    protected $casts = [
        'expense_date' => 'date',
        'is_over_limit' => 'boolean', // Mengubah 0/1 di DB menjadi true/false
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