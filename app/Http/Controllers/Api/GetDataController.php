<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PersetujuanRaker;
use App\Models\PhoneKeyPegawai;
use App\Models\Raker;

class GetDataController extends Controller
{
    public function getData(Request $request)
    {
        $data = [];
        if ($request->persetujuanRaker) {
            $persetujuanRaker = PersetujuanRaker::all();
            $persetujuanRaker = $persetujuanRaker->map(function ($item, $index) {
                $new_data = [];
                $raker = $item->raker;
                $sekretaris_bidang = $raker->sekretarisBidang;
                $ruangan = $raker->ruangan;
                $new_data['id_raker'] = $raker->id;
                $new_data['nama_raker'] = $raker->nama_raker;
                $new_data['deskripsi_raker'] = $raker->deskripsi_raker;
                $new_data['tanggal_jam_masuk_raker'] = $raker->tanggal_jam_masuk_raker;
                $new_data['tanggal_jam_keluar_raker'] = $raker->tanggal_jam_keluar_raker;
                $new_data['jumlah_peserta_raker'] = $raker->jumlah_peserta_raker;
                $new_data['id_ruangan'] = $ruangan->id;
                $new_data['nama_ruangan'] = $ruangan->nama_ruangan;
                $new_data['kapasitas_ruangan'] = $ruangan->kapasitas_ruangan;
                $new_data['id_sekretaris_bidang'] = $sekretaris_bidang->id;
                $new_data['nama_sekretaris'] = $sekretaris_bidang->nama_sekretaris;
                $new_data['bidang_bidang'] = $sekretaris_bidang->bidang_bidang;
                $new_data['no_telpon_bidang'] = $sekretaris_bidang->no_telpon_bidang;
                $new_data['id_persetujuan_raker'] = $item->id;
                $new_data['status_persetujuan_raker'] = $item->status_persetujuan_raker;
                $new_data['deskripsi_persetujuan_raker'] = $item->deskripsi_persetujuan_raker;
                return $new_data;
            });

            $count = $persetujuanRaker->count();
            $data['persetujuanRaker'] = [
                'raker' => $persetujuanRaker,
                'count' => $count,
            ];
        } else {
            $raker = Raker::all()->groupBy('id_ruangan')->map(function ($raker, $index) {

                $ruangan = $raker[0]->ruangan;

                $data = $raker->map(function ($raker, $index) {
                    $new_data = [];
                    $sekretaris_bidang = $raker->sekretarisBidang;
                    $ruangan = $raker->ruangan;
                    $new_data['id_raker'] = $raker->id;
                    $new_data['nama_raker'] = $raker->nama_raker;
                    $new_data['deskripsi_raker'] = $raker->deskripsi_raker;
                    $new_data['tanggal_jam_masuk_raker'] = date('d-m-Y H:i:s', strtotime($raker->tanggal_jam_masuk_raker));
                    $new_data['tanggal_jam_keluar_raker'] = $raker->tanggal_jam_keluar_raker;
                    $new_data['jumlah_peserta_raker'] = $raker->jumlah_peserta_raker;
                    $new_data['id_sekretaris_bidang'] = $sekretaris_bidang->id;
                    $new_data['nama_sekretaris'] = $sekretaris_bidang->nama_sekretaris;
                    $new_data['bidang_bidang'] = $sekretaris_bidang->bidang_bidang;
                    $new_data['no_telpon_bidang'] = $sekretaris_bidang->no_telpon_bidang;
                    $new_data['anggota_rapat'] = $raker->pesertaRaker->count() > 0 ? $raker->pesertaRaker->map(function ($item, $index) {
                        $item->pegawaiPerusahaan;
                        return $item;
                    }) : [];


                    $new_data['notulen_raker'] = $raker->notulenRaker;


                    return $new_data;
                });

                return [
                    'id_ruangan' => $ruangan->id,
                    'nama_ruangan' => $ruangan->nama_ruangan,
                    'kapasitas_ruangan' => $ruangan->kapasitas_ruangan,
                    'raker' => $data,
                ];
            });
            $count = $raker->count();

            $data = [
                'room' => array_values($raker->toArray()),
                'count' => $count,
            ];
        }

        return response([
            'msg' => null,
            'data' => $data,
            'err' => null,
        ], 200);
    }

    public function profileKaryawan($phone_key)
    {
        $karyawan = PhoneKeyPegawai::where('phone_key', $phone_key)->first()->pegawaiPerusahaan;

        return response([
            'status' => true,
            'data' => $karyawan,
            'msg' => 'success'
        ]);
    }
}
