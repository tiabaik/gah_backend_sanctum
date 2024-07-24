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
        Schema::create('custumer', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_identitas');
            $table->string('no_telp');
            $table->string('email');
            $table->string('alamat');
            $table->string('password')->nullable();
            $table->string('nama_institusi')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custumer');
    }
};
