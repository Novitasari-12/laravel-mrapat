<?php

namespace App\Http\Controllers\Base\SekretarisBidang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Raker;
use Illuminate\Support\Facades\Auth;

class SekretarisBidangKehadiranRapatController extends Controller
{
    private function getSekretarisBidang()
    {
        return auth()->user()->sekretarisBidang;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persetujuanRapat = $this->getSekretarisBidang()->persetujuanRaker;
        if (isset($persetujuanRapat[0])) {
            $persetujuan = [];
            foreach ($persetujuanRapat as $key => $value) {
                if ($value->status_persetujuan_raker) {
                    $persetujuan[] = $value;
                }
            }
            if (isset($persetujuan[0])) {
                $raker = [];
                foreach ($persetujuan as $key => $value) {
                    $raker[] = $value->raker;
                }
                return view('sekretaris_bidang.kehadiran_rapat.index', compact('persetujuan', 'raker'));
            }
        }
        return redirect()->route('sb_permohonan_rapat.index')->withDanger('Belum ada rapat yang di setujui');
    }

    public function detail($id_rapat)
    {
        $sekretaris_bidang_id = Auth::user()->sekretarisBidang->id;
        $rapat = Raker::where('id_sekretaris_bidang', $sekretaris_bidang_id)->find($id_rapat);
        if (!isset($rapat)) return abort(404);

        $peserta_rapat = $rapat->pesertaRaker;

        return view('sekretaris_bidang.kehadiran_rapat.detail', compact('peserta_rapat', 'rapat'));
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
            return view('sekretaris_bidang.kehadiran_rapat.show', compact('raker'));
        }
        return redirect()->route('sb_permohonan_rapat.index')->withDanger('Belum ada kehadiran rapat yang dapat dilihat');
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
