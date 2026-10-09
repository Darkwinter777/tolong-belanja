<?php

namespace Modules\Kost\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KontrakSewa extends Model
{
    use HasFactory;

    protected $table = 'kost_kontrak_sewas';

    protected $fillable = [
        'kost_kamar_id',
        'kost_penghuni_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'harga_bulanan',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'harga_bulanan' => 'decimal:2',
    ];

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'kost_kamar_id');
    }

    public function penghuni(): BelongsTo
    {
        return $this->belongsTo(Penghuni::class, 'kost_penghuni_id');
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'kost_kontrak_sewa_id');
    }
}
