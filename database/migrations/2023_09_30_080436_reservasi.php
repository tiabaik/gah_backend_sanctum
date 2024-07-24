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
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_custumer')->constrained('custumer');
            $table->foreignId('id_pegawai')->nullable()->constrained('pegawai');
            $table->foreignId('id_jenis_custumer')->constrained('jenis_custumer');
            $table->Date('tgl_reservasi');
            $table->Date('tgl_cek_in');
            $table->Date('tgl_cek_out');
            $table->Date('tgl_uang_jaminan')->nullable();
            $table->Date('tgl_deposit')->nullable();
            $table->integer('org_dewasa');
            $table->integer('org_anak');
            $table->String('kode_booking')->nullable();
            $table->integer('uang_deposit')->nullable();
            $table->integer('uang_jaminan')->nullable();
            $table->string('status_reservasi');
            $table->string('permintaan_khusus')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }

 

    /**
     * Reverse the migrations.
     */
};
