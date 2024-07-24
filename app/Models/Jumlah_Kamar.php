<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jumlah_Kamar extends Model
{
    use HasFactory;
        protected $table='Jumlah_kamar';
        protected $fillable = [
            'id_tipe',
            'id_reservasi',
            'jumlah_kamar',
    ];

    public function Tipe_kamar()
            {
                return $this->belongsTo(Tipe_kamar::class, 'id_tipe', 'id');
            }

    public function Reservasi()
            {
                return $this->belongsTo(Season::class, 'id_Reservasi', 'id');
            }
}
