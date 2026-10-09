<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kost_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kost_kontrak_sewa_id')->constrained('kost_kontrak_sewas')->cascadeOnDelete();
            $table->date('periode_bulan');
            $table->decimal('jumlah_tagihan', 12, 2);
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_bayar')->nullable();
            $table->enum('status', ['belum_lunas', 'lunas', 'telat'])->default('belum_lunas');
            $table->string('metode_pembayaran')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kost_pembayarans');
    }
};
