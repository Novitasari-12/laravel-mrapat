<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PersetujuanRaker;
use Illuminate\Http\Request;

class RapatController extends Controller
{
    public function show($id)
    {

        $persetujuan_rapat = PersetujuanRaker::with(['raker' => function ($query) {
            return $query->with(['kosumsiRapat', 'jenisRapat', 'ruangan']);
        }])
            ->where('id_raker', $id)
            ->first();

        if (!isset($persetujuan_rapat)) return response([
            'message' => 'Data persetujuan rapat tidak ditemukan',
            'errors' => [
                'id_raker' => "Tidak ada rapat yang di setujui dengan id {$id}"
            ],
            'data' => null,
        ], 400);

        $persetujuan_rapat->setHidden(['deskripsi_persetujuan_raker']);
        $persetujuan_rapat->raker->setHidden(['file_undangan_rapat']);

        return response([
            'message' => 'Data rapat berhasil di tampilkan',
            'data' => $persetujuan_rapat,
            'errors' => null,
        ]);
    }
}
