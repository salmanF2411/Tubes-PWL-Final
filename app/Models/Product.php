<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'image_path',
        'unit',
        'purchase_price',
        'selling_price',
        'minimum_stock',
        'is_active',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'minimum_stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function transactionItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function totalStock(?array $storeIds = null): int
    {
        $query = $this->stocks();

        if ($storeIds !== null) {
            $query->whereIn('store_id', $storeIds);
        }

        return (int) $query->sum('current_stock');
    }

    public function stockBadgeType(int $quantity): string
    {
        if ($quantity <= 0) {
            return 'danger';
        }

        if ($quantity <= $this->minimum_stock) {
            return 'warning';
        }

        return 'success';
    }

    public function stockLabel(int $quantity): string
    {
        if ($quantity <= 0) {
            return 'Habis';
        }

        return $quantity.' '.$this->unit;
    }
}