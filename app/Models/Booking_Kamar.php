<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking_Kamar extends Model
{
    use HasFactory;
    protected $table='Booking_Kamar';
    protected $fillable = [
        'id_reservasi',
        'id_kamar',

    ];
}
