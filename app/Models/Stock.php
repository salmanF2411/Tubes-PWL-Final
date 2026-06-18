<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'product_id',
        'current_stock',
        'minimum_stock',
        'last_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'current_stock' => 'integer',
            'minimum_stock' => 'integer',
            'last_updated_at' => 'datetime',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getEffectiveMinimumStockAttribute(): int
    {
        return $this->minimum_stock ?: (int) ($this->product?->minimum_stock ?? 0);
    }

    public function getBadgeTypeAttribute(): string
    {
        if ($this->current_stock <= 0) {
            return 'danger';
        }

        if ($this->current_stock <= $this->effective_minimum_stock) {
            return 'warning';
        }

        return 'success';
    }

    public function getStatusLabelAttribute(): string
    {
        if ($this->current_stock <= 0) {
            return 'Habis';
        }

        if ($this->current_stock <= $this->effective_minimum_stock) {
            return 'Rendah';
        }

        return 'Tersedia';
    }
}