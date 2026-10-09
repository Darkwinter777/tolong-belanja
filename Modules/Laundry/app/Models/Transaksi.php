<?php

namespace Modules\Laundry\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'laundry_transaksis';

    protected $fillable = [
        'laundry_order_id',
        'jumlah_bayar',
        'metode_pembayaran',
        'tanggal_bayar',
        'status',
    ];

    protected $casts = [
        'jumlah_bayar' => 'decimal:2',
        'tanggal_bayar' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'laundry_order_id');
    }
}
