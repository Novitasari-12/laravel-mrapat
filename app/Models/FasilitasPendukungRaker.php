<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasPendukungRaker extends Model
{
    protected $table = "fasilitas_pendukung_raker";
    protected $fillable = [
        "id",
        "id_raker",
        "fasilitas_pendukung",
    ];

    public function raker(){
        return $this->belongsTo('App\Models\Raker', 'id_raker');
    }

    
}
