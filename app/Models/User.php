<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'store_id',
        'name',
        'email',
        'phone',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function canAccessAllStores(): bool
    {
        return $this->hasRole('owner');
    }

    public function visibleStoreIds(): array
    {
        if ($this->canAccessAllStores()) {
            return Store::query()->pluck('id')->all();
        }

        return $this->store_id ? [$this->store_id] : [];
    }

    public function getRoleLabelAttribute(): string
    {
        $role = $this->getRoleNames()->first();

        return [
            'owner' => 'Owner',
            'store_manager' => 'Manajer Toko',
            'supervisor' => 'Supervisor',
            'cashier' => 'Kasir',
            'warehouse_staff' => 'Pegawai Gudang',
        ][$role] ?? 'User';
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'active' ? 'Aktif' : 'Nonaktif';
    }

    public function getStatusBadgeTypeAttribute(): string
    {
        return $this->status === 'active' ? 'success' : 'danger';
    }
}