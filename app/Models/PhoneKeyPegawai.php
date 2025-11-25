<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneKeyPegawai extends Model
{
    protected $table = "phone_key_pegawai";
    protected $fillable = [
        "id",
        "id_pegawai_perusahaan",
        "phone_key",
    ];

    public function pegawaiPerusahaan(){
        return $this->belongsTo('App\Models\PegawaiPerusahaan', 'id_pegawai_perusahaan');
    }

}
