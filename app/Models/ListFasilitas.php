<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListFasilitas extends Model
{
    protected $table = 'list_fasilitas' ;
    protected $fillable = ["id", 'fasilitas'] ;
}
