<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;
        protected $table='Reservasi';
        protected $fillable = [
            'id_custumer',
            'id_pegawai',
            'id_jenis_custumer',
            'tgl_reservasi',
            'tgl_cek_in',
            'tgl_cek_out',
            'tgl_uang_jaminan',
            'tgl_deposit',
            'org_dewasa',
            'org_anak',
            'kode_booking',
            'uang_deposit',
            'uang_jaminan',
            'status_reservasi',
            'permintaan_khusus',
            
        ];

        public function Custumer()
            {
                return $this->belongsTo(Custumer::class, 'id_custumer', 'id');
            }

        public function Pegawai()
            {
                return $this->belongsTo(Season::class, 'id_pegawai', 'id');
            }
        
         public function Jenis_Custumer()
            {
                return $this->belongsTo(Season::class, 'id_jenis_custumer', 'id');
            }

            
}
