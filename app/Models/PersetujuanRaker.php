<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersetujuanRaker extends Model
{
    protected $table = "persetujuan_raker";
    protected $fillable = [
        "id",
        "id_sekretaris_bidang",
        "id_raker",
        "status_persetujuan_raker",
        "deskripsi_persetujuan_raker",
    ];

    public function raker(){
        return $this->belongsTo('App\Models\Raker', 'id_raker');
    }

    public function sekretarisBidang(){
        return $this->belongsTo('App\Models\SekretarisBidang', 'id_sekretaris_bidang');
    }
}
