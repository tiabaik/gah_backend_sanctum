<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisCustumer extends Model
{
    use HasFactory;
    protected $table='JenisCustumer';
    protected $fillable = [
        'nama_jenis_custumer',
    ];
}
