<?php

namespace Modules\Kost\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Models\Pelanggan;

class Penghuni extends Model
{
    use HasFactory;

    protected $table = 'kost_penghunis';

    protected $fillable = [
        'pelanggan_id',
        'nama',
        'no_hp',
        'email',
        'no_ktp',
        'tanggal_masuk',
        'alamat_asal',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function kontrakSewas(): HasMany
    {
        return $this->hasMany(KontrakSewa::class, 'kost_penghuni_id');
    }
}
