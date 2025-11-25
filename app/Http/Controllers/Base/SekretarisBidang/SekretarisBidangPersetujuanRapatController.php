<?php

namespace App\Http\Controllers\Base\SekretarisBidang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SekretarisBidangPersetujuanRapatController extends Controller
{
    private function getSekretarisBidang(){
        return auth()->user()->sekretarisBidang ;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persetujuanRapat = $this->getSekretarisBidang()->persetujuanRaker ;
        if(isset($persetujuanRapat[0])){
            $persetujuan = [];
            foreach ($persetujuanRapat as $key => $value) {
                if($value->status_persetujuan_raker){
                    $persetujuan[] = $value ;
                }
            }
            if(isset($persetujuan[0])){
                $raker = [];
                foreach ($persetujuan as $key => $value) {
                    $raker[$value->id] = [
                        'raker' => $value->raker->id,
                        'ruangan' => $value->raker->id_ruangan,
                        'nama_raker' => $value->raker->nama_raker,
                        'waktu_masuk' => $value->raker->tanggal_jam_masuk_raker,
                        'waktu_keluar' => $value->raker->tanggal_jam_keluar_raker,
                        'jumlah_peserta' => $value->raker->jumlah_peserta_raker,
                    ];
                }
                return view('sekretaris_bidang.persetujuan_rapat.index', compact('persetujuan', 'raker'));
            }
        }
        return redirect()->route('sb_permohonan_rapat.index')->withDanger('Belum ada rapat yang di setujui');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $raker = $this->getSekretarisBidang()->raker->find($id);
        if (isset($raker)) {
            $qrcode = [
                'raker' => $raker->id,
                'ruangan' => $raker->id_ruangan,
                'nama_raker' => $raker->nama_raker,
                'waktu_masuk' => $raker->tanggal_jam_masuk_raker,
                'waktu_keluar' => $raker->tanggal_jam_keluar_raker,
                'jumlah_peserta' => $raker->jumlah_peserta_raker,
            ];
            return view('sekretaris_bidang.persetujuan_rapat.show', compact('raker', 'qrcode'));
        }
        return redirect()->route('sb_permohonan_rapat.index')->withDanger('Belum ada rapat yang dapat disetujui');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
