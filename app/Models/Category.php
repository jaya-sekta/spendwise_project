<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'category_name',
        'monthly_limit',
        'category_type',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // Kata kunci -> icon & warna. Tambah/ubah sesuka hati tanpa perlu migration.
    private const ICON_MAP = [
        'makan'       => ['icon' => 'fa-solid fa-utensils',        'color' => '#F59E0B'],
        'transport'   => ['icon' => 'fa-solid fa-bus',              'color' => '#0EA5E9'],
        'bensin'      => ['icon' => 'fa-solid fa-gas-pump',         'color' => '#0EA5E9'],
        'belanja'     => ['icon' => 'fa-solid fa-cart-shopping',    'color' => '#EC4899'],
        'hiburan'     => ['icon' => 'fa-solid fa-gamepad',          'color' => '#8B5CF6'],
        'game'        => ['icon' => 'fa-solid fa-gamepad',          'color' => '#8B5CF6'],
        'kesehatan'   => ['icon' => 'fa-solid fa-heart-pulse',      'color' => '#EF4444'],
        'pendidikan'  => ['icon' => 'fa-solid fa-graduation-cap',   'color' => '#10B981'],
        'sekolah'     => ['icon' => 'fa-solid fa-graduation-cap',   'color' => '#10B981'],
        'tagihan'     => ['icon' => 'fa-solid fa-file-invoice-dollar', 'color' => '#64748B'],
        'listrik'     => ['icon' => 'fa-solid fa-bolt',             'color' => '#64748B'],
        'kos'         => ['icon' => 'fa-solid fa-house',            'color' => '#4F46E5'],
        'sewa'        => ['icon' => 'fa-solid fa-house',            'color' => '#4F46E5'],
        'pakaian'     => ['icon' => 'fa-solid fa-shirt',            'color' => '#EC4899'],
        'kopi'        => ['icon' => 'fa-solid fa-mug-hot',          'color' => '#F59E0B'],
        'jajan'       => ['icon' => 'fa-solid fa-mug-hot',          'color' => '#F59E0B'],
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }

    public function scopeOwnedBy(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId)->where('is_default', false);
    }

    public function scopeVisibleTo(Builder $query, int $userId): Builder
    {
        return $query->where(function (Builder $q) use ($userId) {
            $q->where('is_default', true)->orWhere('user_id', $userId);
        });
    }

    // Accessor: $category->icon
    public function getIconAttribute(): string
    {
        return $this->matchMeta()['icon'];
    }

    // Accessor: $category->color
    public function getColorAttribute(): string
    {
        return $this->matchMeta()['color'];
    }

    // Accessor: $category->description
    public function getDescriptionAttribute(): string
    {
        return $this->category_type === 'primary'
            ? 'Kebutuhan pokok bulanan.'
            : 'Pengeluaran gaya hidup / konsumtif.';
    }

    private function matchMeta(): array
    {
        $name = strtolower($this->category_name);

        foreach (self::ICON_MAP as $keyword => $meta) {
            if (str_contains($name, $keyword)) {
                return $meta;
            }
        }

        // Fallback kalau tidak ada kata kunci yang cocok
        return $this->category_type === 'primary'
            ? ['icon' => 'fa-solid fa-house', 'color' => '#4F46E5']
            : ['icon' => 'fa-solid fa-bag-shopping', 'color' => '#F59E0B'];
    }
}