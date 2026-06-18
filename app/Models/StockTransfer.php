<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_code',
        'from_store_id',
        'to_store_id',
        'product_id',
        'requested_by',
        'confirmed_by',
        'quantity',
        'status',
        'transfer_date',
        'confirmed_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'transfer_date' => 'datetime',
            'confirmed_at' => 'datetime',
        ];
    }

    public function fromStore(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'from_store_id');
    }

    public function toStore(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'to_store_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function getBadgeTypeAttribute(): string
    {
        return [
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
        ][$this->status] ?? 'neutral';
    }

    public function getStatusLabelAttribute(): string
    {
        return [
            'pending' => 'Proses',
            'confirmed' => 'Terkirim',
            'cancelled' => 'Dibatalkan',
        ][$this->status] ?? ucfirst($this->status);
    }
}