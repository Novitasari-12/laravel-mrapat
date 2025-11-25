<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\InformasiGambar;
use App\Models\Raker;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class JadwalRapatController extends Controller
{
    public function index()
    {
        return view('jadwal_rapat.index');
    }

    public function layar_penuh()
    {
        return view('jadwal_rapat.layar_penuh');
    }

    public function show(Request $request)
    {
        $timetamps = date('Y-m-d H:i:s');
        $raker = new Raker();
        $raker = $raker->get();
        // $raker = Raker::where('tanggal_jam_masuk_raker', '>=', $timetamps)->get();
        $raker = collect($raker);
        $raker = $raker->map(function ($item, $index) {
            return [
                'start_date' => $item->tanggal_jam_masuk_raker,
                'end_date' => $item->tanggal_jam_keluar_raker,
                'text' => $item->nama_raker.' - '.$item->ruangan->nama_ruangan.' - '.$item->deskripsi_raker,
                'section_id' => $item->id_ruangan,
            ];
        });

        $ruangan_raker = $raker->groupBy('section_id')->map(function ($item, $index) {
            return $index;
        })->toArray();

        $ruangan = new Ruangan();
        if (!isset($request->ruangan)) {
            $ruangan = $ruangan->whereIn('id', $ruangan_raker);
        }
        $ruangan = $ruangan->get();
        $ruangan = collect($ruangan);
        $ruangan = $ruangan->map(function ($item, $index) {
            return [
                'key' => $item->id,
                'label' => $item->nama_ruangan,
            ];
        })->toArray();

        if (isset($request->type)) {
            $type = $request->type;
            if ($type == 'selections') {
                return response($ruangan);
            }
            if ($type == 'data') {
                return response($raker);
            }
        }

        return response([
            'sections' => $ruangan,
            'data' => $raker,
        ]);
    }

    public function info()
    {
        $date_now = date('Y-m-d H:i:s');
        $igambar = InformasiGambar::where('waktu_mulai_ditampilkan', '<=', $date_now)->where('waktu_selesai_ditampilkan', '>=', $date_now)->get();

        return view('jadwal_rapat.info', compact('igambar'));
    }
}
