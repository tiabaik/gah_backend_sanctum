<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table='Transaksi';
    protected $casts= [
        'id' => 'string'
    ];
    protected $fillable = [
            'id',
            'id_pegawai',
            'id_reservasi',
            'tgl_transaksi',
            'jumlah_pembayaran',
            'total_pembayaran',
            'tax',
            'diskon',
            'total_akhir_pembayaran',
        

    ];

    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id');
    }

    public function Reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id');
    }
}
