<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotulenRaker extends Model
{
    protected $table = "notulen_raker";
    protected $fillable = [
        "id",
        "id_raker",
        "username",
        "password",
        "hasil_raker",
        "status_tulis",
    ];

    public function raker(){
        return $this->belongsTo('App\Models\Raker', 'id_raker');
    }
}
