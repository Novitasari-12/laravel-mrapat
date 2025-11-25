<?php

namespace App\Http\Controllers\Base\Absensi;

use App\Http\Controllers\Controller as MainController;
use App\Models\PegawaiPerusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends MainController
{
    public function index(Request $request)
    {
        return view('absensi.index');
    }

    public function ambilAbsensi(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $valid = Validator::make($request->all(), [
            'id_rapat' => ['required'],
            'nip' => ['required'],
            'password' => ['required'],
            'upload_foto' => ['required', 'file']
        ]);

        if ($valid->fails()) {
            return redirect()
                ->back()
                ->withErrors($valid)
                ->withInput();
        }

        $pegawai = PegawaiPerusahaan::where('nip_pegawai', $request->nip)->first();
        if (!isset($pegawai) || !Hash::check($request->password, $pegawai->password)) {
            return redirect()->back()->withInput()->withDanger('NIP ATAU PASSWORD SALAH');
        }
        $pesertaRapat = $pegawai->pesertaRaker->where('id_raker', $request->id_rapat)->first();
        if (!isset($pesertaRapat)) {
            return redirect()->back()->withInput()->withDanger('RAPAT DENGAN ID ' . $request->id_rapat . ' TIDAL TERSEDIA');
        }
        $raker = $pesertaRapat->raker;
        if (!isset($raker)) {
            return redirect()->back()->withInput()->withDanger('RAPAT DENGAN ID ' . $request->id_rapat . ' TIDAL TERSEDIA');
        }

        $waktuAbsen = date('Y-m-d H:i');
        $intWaktuAbsen = strtotime($waktuAbsen);
        $intWaktuMasukRaker = strtotime($raker->tanggal_jam_masuk_raker);
        $keteranganAbsensi = 'TELAT';
        if ($intWaktuAbsen <= $intWaktuMasukRaker) {
            $keteranganAbsensi = 'TEPAT WAKTU';
        }

        $upload_foto = null;
        if ($request->hasFile('upload_foto')) {
            $foto = $request->file('upload_foto');
            $upload_foto = json_encode([
                'path' => '/storage/' . $foto->store("/absen/{$raker->id}", "public"),
                'originalName' => $foto->getClientOriginalName(),
                'mimeType' => $foto->getClientMimeType(),
            ]);
        }

        $pesertaRapat->update([
            'status_absensi' => 1,
            'tanggal_jam_absensi' => $waktuAbsen,
            'keterangan_absensi' => $keteranganAbsensi,
            'upload_foto' => $upload_foto,
        ]);
        $request->session()->flash('absensi', $pesertaRapat);

        return redirect()->back()->withSuccess('BERHASIL MENGAMBIL ABSENSI');
    }
}
