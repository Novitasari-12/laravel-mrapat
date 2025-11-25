<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raker extends Model
{
    protected $table = "raker";
    protected $fillable = [
        "id",
        "id_sekretaris_bidang",
        "id_ruangan",
        "nama_raker",
        "deskripsi_raker",
        "tanggal_jam_masuk_raker",
        "tanggal_jam_keluar_raker",
        "jumlah_peserta_raker",
    ];

    public function sekretarisBidang(){
        return $this->belongsTo('App\Models\SekretarisBidang', 'id_sekretaris_bidang');
    }

    public function ruangan(){
        return $this->belongsTo('App\Models\Ruangan', 'id_ruangan');
    }

    public function fasilitasPendukungRaker(){
        return $this->hasMany('App\Models\FasilitasPendukungRaker', 'id_raker');
    }


    public function persetujuanRaker(){
        return $this->hasOne('App\Models\PersetujuanRaker', 'id_raker');
    }

    public function pesertaRaker(){
        return $this->hasMany('App\Models\PesertaRaker', 'id_raker');
    }

    public function notulenRaker(){
        return $this->hasOne('App\Models\NotulenRaker', 'id_raker');
    }

    
}
