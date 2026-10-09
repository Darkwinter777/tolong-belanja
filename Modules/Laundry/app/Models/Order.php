<?php

namespace Modules\Laundry\Models;

use App\Notifications\OrderStatusUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Modules\Core\Models\Pelanggan;

class Order extends Model
{
    use HasFactory;

    protected $table = 'laundry_orders';

    protected $fillable = [
        'pelanggan_id',
        'kode_order',
        'nama_pelanggan',
        'no_hp_pelanggan',
        'laundry_layanan_id',
        'berat_atau_jumlah',
        'total_harga',
        'estimasi_selesai',
        'status',
        'catatan',
    ];

    protected $casts = [
        'berat_atau_jumlah' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'estimasi_selesai' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $order) {
            if (empty($order->kode_order)) {
                $order->kode_order = 'LD-'.now()->format('Ymd').'-'.strtoupper(Str::random(4));
            }
        });

        static::updated(function (self $order) {
            if ($order->wasChanged('status') && $order->pelanggan) {
                $order->pelanggan->notify(new OrderStatusUpdated($order));
            }
        });
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'laundry_layanan_id');
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'laundry_order_id');
    }
}
