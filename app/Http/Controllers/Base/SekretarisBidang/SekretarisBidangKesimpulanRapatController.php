<?php

namespace App\Http\Controllers\Base\SekretarisBidang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\UserNotification;
use App\Models\NotulenRaker;
use App\Models\Raker;
use Illuminate\Support\Facades\Mail;

class SekretarisBidangKesimpulanRapatController extends Controller
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
                $notulen = [];
                foreach ($persetujuan as $key => $value) {
                    if (isset($value->raker->notulenRaker->hasil_raker)) {
                        $notulen[] = $value->raker->notulenRaker;
                    }
                }
                if (isset($notulen[0])) {
                    return view('sekretaris_bidang.kesimpulan_rapat.index', compact('persetujuan', 'notulen'));
                }
            }
        }
        return redirect()->route('sb_permohonan_rapat.index')->withDanger('Belum ada hasil rapat yang dapat dilihat');
    }

    public function publish($id_notulen)
    {
        $notulen = NotulenRaker::find($id_notulen);
        if (!isset($notulen)) return abort(404);

        foreach ($notulen->raker->pesertaRaker as $key => $value) {
            $pegawai = $value->pegawaiPerusahaan;
            Mail::to($pegawai->email_pegawai)->send(new UserNotification('mail.send_hasil_raker', [
                "notulen" => $notulen,
                "pegawai" => $pegawai,
                "raker" => $notulen->raker,
                "peserta" => $notulen->raker->pesertaRaker,
            ]));
        }

        return redirect()->back()->withSuccess('Berhasil mengerimkan kesimpulan rapat ke semua pengawai');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $raker = $this->getSekretarisBidang()->raker->find($id);
        if (isset($raker)) {
            if ($request->has('print')) {
                return view('sekretaris_bidang.kesimpulan_rapat.print', compact('raker'));
            } else {
                return view('sekretaris_bidang.kesimpulan_rapat.show', compact('raker'));
            }
        }

        return redirect()->route('sb_permohonan_rapat.index')->withDanger('Belum ada hasil rapat yang dapat dilihat');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $raker = $this->getSekretarisBidang()->raker->find($id);
        if (!isset($raker)) return abort(404);

        return view('sekretaris_bidang.kesimpulan_rapat.update', compact('raker'));
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
        $raker = $this->getSekretarisBidang()->raker->find($id);

        if (isset($raker)) {
            $notulen = $raker->notulenRaker;

            $notulen->status_tulis = $request->status_tulis;

            if ($request->has('hasil_raker')) {
                $notulen->hasil_raker = $request->hasil_raker;
                $notulen->status_tulis = false;
            }

            $notulen->save();

            if ($request->header('Accept') == 'application/json') {
                return response()->json([
                    'message' => 'success',
                    'data' => $notulen,
                    'errors' => null,
                ]);
            } else {
                return redirect()->back()->withSuccess('Berhasil tukar status tulis');
            }
        }
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
