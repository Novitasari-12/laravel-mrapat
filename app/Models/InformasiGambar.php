<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiGambar extends Model
{
    protected $table = 'informasi_gambar';
    protected $fillable = [
        'nama',
        'gambar',
        'informasi_gambar',
        'waktu_mulai_ditampilkan',
        'waktu_selesai_ditampilkan',
    ];
}
