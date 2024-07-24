<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Kamar extends Model
{
    use HasFactory;
    
    protected $table='kamar';
    protected $fillable = [
        'id',
        'id_tipe',
        'status_ketersedian_kamar',
        'deskripsi',
        'kapasitas',
        'pilihan_bad',

    ];

    public function Tipe_kamar()
    {
        return $this->belongsTo(Tipe_kamar::class, 'id_tipe', 'id');
    }
   
}
