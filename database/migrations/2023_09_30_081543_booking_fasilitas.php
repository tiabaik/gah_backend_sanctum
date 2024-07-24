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
        Schema::create('booking_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_fasilitas')->constrained('fasilitas');
            $table->foreignId('id_reservasi')->constrained('reservasi')->onDelete('cascade')->onUpdate('cascade');
            $table->Date('tgl_booking_fasilitas');
            $table->integer('jumlah_booking_fasilitas');
            $table->rememberToken();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_fasilitas');
    }
};
