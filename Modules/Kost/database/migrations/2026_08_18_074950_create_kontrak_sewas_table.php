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
        Schema::create('kost_kontrak_sewas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kost_kamar_id')->constrained('kost_kamars')->cascadeOnDelete();
            $table->foreignId('kost_penghuni_id')->constrained('kost_penghunis')->cascadeOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->decimal('harga_bulanan', 12, 2);
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kost_kontrak_sewas');
    }
};
