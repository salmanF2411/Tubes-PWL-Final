<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'store_id',
        'cashier_id',
        'transaction_date',
        'subtotal',
        'discount',
        'total',
        'paid_amount',
        'change_amount',
        'payment_method',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'datetime',
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'change_amount' => 'decimal:2',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopeBetweenDates(Builder $query, ?string $startDate, ?string $endDate): Builder
    {
        return $query
            ->when($startDate, fn (Builder $query) => $query->whereDate('transaction_date', '>=', $startDate))
            ->when($endDate, fn (Builder $query) => $query->whereDate('transaction_date', '<=', $endDate));
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return [
            'cash' => 'Tunai',
            'qris' => 'QRIS',
            'transfer' => 'Transfer',
            'debit' => 'Debit',
        ][$this->payment_method] ?? ucfirst($this->payment_method);
    }

    public function getStatusLabelAttribute(): string
    {
        return [
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'refunded' => 'Refund',
        ][$this->status] ?? ucfirst($this->status);
    }

    public function getBadgeTypeAttribute(): string
    {
        return [
            'completed' => 'success',
            'cancelled' => 'danger',
            'refunded' => 'warning',
        ][$this->status] ?? 'neutral';
    }
}