<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = "ruangan" ;
    protected $fillable = [
        "id",
        "nama_ruangan",
        "kapasitas_ruangan",
    ];

    public function raker(){
        return $this->hasMany('App\Models\Raker', 'id_ruangan');
    }
}
