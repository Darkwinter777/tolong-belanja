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
        Schema::create('laundry_orders', function (Blueprint $table) {
            $table->id();
            $table->string('kode_order')->unique();
            $table->string('nama_pelanggan');
            $table->string('no_hp_pelanggan')->nullable();
            $table->foreignId('laundry_layanan_id')->constrained('laundry_layanans');
            $table->decimal('berat_atau_jumlah', 8, 2);
            $table->decimal('total_harga', 12, 2);
            $table->dateTime('estimasi_selesai')->nullable();
            $table->enum('status', ['diterima', 'proses', 'selesai', 'diambil'])->default('diterima');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laundry_orders');
    }
};
