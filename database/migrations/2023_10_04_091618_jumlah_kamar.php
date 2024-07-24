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
           
            Schema::create('jumlah_kamar', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_tipe')->constrained('tipe_kamar');
                $table->foreignId('id_reservasi')->constrained('reservasi');
                $table->integer('jumlah_kamar');
                $table->rememberToken();
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jumlah_kamar');
    }
};
