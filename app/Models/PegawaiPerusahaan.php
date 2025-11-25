<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiPerusahaan extends Model
{
    protected $table = "pegawai_perusahaan";
    protected $fillable = [
        "id",
        "nip_pegawai",
        "nama_pegawai",
        "unit_pegawai",
        "bidang_pegawai",
        "email_pegawai",
        "no_telpon",
        "password"
    ];

    protected $hidden = [
        'password',
    ];

    public function phoneKeyPegawai(){
        return $this->hasMany('App\Models\PhoneKeyPegawai', 'id_pegawai_perusahaan');
    }

    public function pesertaRaker(){
        return $this->hasMany('App\Models\PesertaRaker', 'id_pegawai_perusahaan');
    }

}
