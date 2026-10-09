<?php

namespace Modules\Kost\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kost_kamars';

    protected $fillable = [
        'nomor_kamar',
        'tipe',
        'harga',
        'status',
        'keterangan',
        'foto_kamar',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'foto_kamar' => 'array',
    ];

    public function kontrakSewas(): HasMany
    {
        return $this->hasMany(KontrakSewa::class, 'kost_kamar_id');
    }
}
