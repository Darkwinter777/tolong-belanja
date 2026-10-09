<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Kost\Models\Penghuni;
use Modules\Laundry\Models\Order;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function penghunis(): HasMany
    {
        return $this->hasMany(Penghuni::class, 'pelanggan_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'pelanggan_id');
    }
}
