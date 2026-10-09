<?php

namespace Modules\Kost\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'kost_pembayarans';

    protected $fillable = [
        'kost_kontrak_sewa_id',
        'periode_bulan',
        'jumlah_tagihan',
        'tanggal_jatuh_tempo',
        'tanggal_bayar',
        'status',
        'metode_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'periode_bulan' => 'date',
        'jumlah_tagihan' => 'decimal:2',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_bayar' => 'date',
    ];

    public function kontrakSewa(): BelongsTo
    {
        return $this->belongsTo(KontrakSewa::class, 'kost_kontrak_sewa_id');
    }
}
