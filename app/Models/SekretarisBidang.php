<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SekretarisBidang extends Model
{
    protected $table = "sekretaris_bidang";
    protected $fillable = [
        "id",
	    "id_user",
        "nama_sekretaris",
        "bidang_sekretaris",
        "no_telpon_sekretaris",
    ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function pegawaiPerusahaan(){
        return $this->hasMany('App\Models\PegawaiPerusahaan', 'id_sekretaris_bidang');
    }

    public function raker(){
        return $this->hasMany('App\Models\Raker', 'id_sekretaris_bidang');
    }

    public function persetujuanRaker(){
        return $this->hasMany('App\Models\PersetujuanRaker', 'id_sekretaris_bidang');
    }    

    public function notulenRaker(){
        return $this->hasMany('App\Models\NotulenRaker', 'id_sekretaris_bidang');
    }  

}
