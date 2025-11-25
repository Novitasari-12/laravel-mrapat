<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaRaker extends Model
{
    protected $table = "peserta_raker";
    protected $fillable = [
        "id",
        "id_raker",
        "id_pegawai_perusahaan",
        "status_absensi",
        "tanggal_jam_absensi",
        "keterangan_absensi",
        "upload_foto"
    ];

    public function raker()
    {
        return $this->belongsTo('App\Models\Raker', 'id_raker');
    }

    public function pegawaiPerusahaan()
    {
        return $this->belongsTo('App\Models\PegawaiPerusahaan', 'id_pegawai_perusahaan');
    }

    public function getUploadFoto()
    {
        $json_obj = json_decode($this->upload_foto);

        return $json_obj;
    }
}
