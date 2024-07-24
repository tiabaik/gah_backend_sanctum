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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('id_pegawai')->constrained('pegawai');
            $table->foreignId('id_reservasi')->constrained('reservasi');
            $table->Date('tgl_transaksi');
            $table->integer('jumlah_pembayaran');
            $table->integer('total_pembayaran');
            $table->integer('tax');
            $table->integer('diskon');
            $table->integer('total_akhir_pembayaran');
            $table->rememberToken();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
