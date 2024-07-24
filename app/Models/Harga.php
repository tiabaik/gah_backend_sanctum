<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;
            protected $table='Harga';
            protected $fillable = [
                'id_tipe',
                'id_season',
                'harga',
        
            ];
        
            public function Tipe_kamar()
            {
                return $this->belongsTo(Tipe_kamar::class, 'id_tipe', 'id');
            }

            public function Season()
            {
                return $this->belongsTo(Season::class, 'id_season', 'id');
            }
}
