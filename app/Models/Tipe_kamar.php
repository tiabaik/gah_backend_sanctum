<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipe_kamar extends Model
{
    use HasFactory;

    protected $table='Tipe_kamar';
    protected $fillable = [
        'nama_tipe',
        'gambar',
        'harga',
        
    ];
}
