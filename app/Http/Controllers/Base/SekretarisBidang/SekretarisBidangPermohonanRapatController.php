<?php

namespace App\Http\Controllers\Base\SekretarisBidang;

use App\Http\Controllers\Controller;
use App\Models\FasilitasPendukungRaker;
use App\Models\ListFasilitas;
use App\Models\NotulenRaker;
use App\Models\PegawaiPerusahaan;
use App\Models\PersetujuanRaker;
use App\Models\PesertaRaker;
use App\Models\Raker;
use App\Models\Ruangan;
use App\MyLibraries\Generate\Id;
use App\MyLibraries\RakerValidation\RakerValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SekretarisBidangPermohonanRapatController extends Controller
{
    private function getSekretarisBidang()
    {
        return auth()->user()->sekretarisBidang;
    }

    private function errMsg($err)
    {
        $err = json_encode($err);
        $errors = [];
        foreach (json_decode($err) as $key => $value) {
            $errors[] = $value[0];
        }

        return $errors;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $raker = $this->getSekretarisBidang()->raker;
        $raker = Raker::orderBy('created_at', 'desc')->where('id_sekretaris_bidang', $this->getSekretarisBidang()->id)->get();
        $persetujuan = isset($raker->persetujuanRaker) ? $raker->persetujuanRaker : [];

        return view('sekretaris_bidang.permohonan_rapat.index', compact('raker', 'persetujuan'));
    }

    public function pengajuan($id_rapat)
    {
        $raker = $this->getSekretarisBidang()->raker->find($id_rapat);
        if (isset($raker)) {
            $persetujuan = PersetujuanRaker::create([
                'id_sekretaris_bidang' => $this->getSekretarisBidang()->id,
                'id_raker' => $raker->id,
                'status_persetujuan_raker' => 0,
                'deskripsi_persetujuan_raker' => '',
            ]);

            return redirect()->route('sb_permohonan_rapat.index')->withSuccess('Pengajuan berhasil ');
        }
    }

    public function batanPengajuan($id_persetujuanRaker)
    {
        $persetujuan = $this->getSekretarisBidang()->persetujuanRaker->find($id_persetujuanRaker);
        if (isset($persetujuan)) {
            $persetujuan->delete();

            return redirect()->route('sb_permohonan_rapat.index')->withSuccess('Batan pengajuan berhasil ');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ruangan = Ruangan::all();
        $pegawai = PegawaiPerusahaan::orderBy('nama_pegawai', 'asc')->get();
        $fasilitas = ListFasilitas::all();

        return view('sekretaris_bidang.permohonan_rapat.create', compact('ruangan', 'pegawai', 'fasilitas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $valid = Validator::make($request->all(), [
            'ruangan' => ['required', 'numeric'],
            'nama_rapat' => ['required', 'string'],
            'tanggal_jam_masuk' => ['required'],
            'tanggal_jam_keluar' => ['required'],
            'jumlah_peserta' => ['required', 'numeric', 'string'],
            'peserta' => ['required'], // id_pegawai
            'fasilitas' => ['required'],
            'notulen' => ['required', 'numeric'], // id_pegawai
            'deskripsi' => ['required', 'string'],
        ]);

        

        $valid->after(function ($validator) use ($request) {
            if (isset($request->tanggal_jam_masuk) && isset($request->tanggal_jam_keluar) && isset($request->ruangan) && isset($request->jumlah_peserta) && $request->notulen && $request->peserta) {
                $waktuMasukRaker = $request->tanggal_jam_masuk;
                $waktuKeluarRaker = $request->tanggal_jam_keluar;
                $idRungan = $request->ruangan;
                $jumlah_peserta = $request->jumlah_peserta;

                if (!RakerValidation::checkWaktuKosong($waktuMasukRaker, $waktuKeluarRaker, $idRungan)) {
                    $waktuMasukRaker = str_replace('T', ' ', $waktuMasukRaker);
                    $waktuKeluarRaker = str_replace('T', ' ', $waktuKeluarRaker);
                    $error = "Ruang telah terpakai pada waktu {$waktuMasukRaker} sampai {$waktuKeluarRaker}";
                    $validator->errors()->add('tanggal_jam_masuk', $error);
                }

                $nowdatetime = strtotime(date('Y-m-d H:i'));
                if (strtotime($waktuMasukRaker) < $nowdatetime) {
                    $error = ' Tidak dapat melakukan raker kurang dari waktu sekarang';
                    $validator->errors()->add('tanggal_jam_masuk', $error);
                }

                if (strtotime($waktuKeluarRaker) < strtotime($waktuMasukRaker)) {
                    $waktuMasukRaker = str_replace('T', ' ', $waktuMasukRaker);
                    $waktuKeluarRaker = str_replace('T', ' ', $waktuKeluarRaker);
                    $error = " Tidak dapat melakukan raker dari rentang dari {$waktuMasukRaker} sampai {$waktuKeluarRaker}";
                    $validator->errors()->add('tanggal_jam_keluar', $error);
                }

                if (!RakerValidation::checkKapasitasRuangan($idRungan, $jumlah_peserta)) {
                    $ruangan = Ruangan::find($idRungan);
                    $error = " Kapasitas maksimal ruangan {$ruangan->jumlah_peserta} ";
                    $validator->errors()->add('jumlah_peserta', $error);
                }

                $notulen = $request->notulen;
                $peserta = $request->peserta;

                if (!in_array($notulen, $peserta)) {
                    $validator->errors()->add('notulen', 'Harus merupakan bagian dari peserta yang di inputkan sebelumnya');
                }

                if (count($peserta) > $jumlah_peserta) {
                    $validator->errors()->add('peserta', 'Pastikan peserta tidak lebih dari inputan jumlah peserta sebelumnya');
                }
            }
        });

        if ($valid->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($valid)
                    ->withInput();
        }

        $data = [
            'id' => Id::generate(new Raker()),
            'id_sekretaris_bidang' => $this->getSekretarisBidang()->id,
            'id_ruangan' => $request->ruangan,
            'nama_raker' => $request->nama_rapat,
            'tanggal_jam_masuk_raker' => $request->tanggal_jam_masuk,
            'tanggal_jam_keluar_raker' => $request->tanggal_jam_keluar,
            'jumlah_peserta_raker' => $request->jumlah_peserta,
            'deskripsi_raker' => $request->deskripsi,
        ];
        $raker = Raker::create($data);

        foreach ($request->fasilitas as $key => $value) {
            FasilitasPendukungRaker::create([
                'id' => Id::generate(new FasilitasPendukungRaker()),
                'id_raker' => $raker->id,
                'fasilitas_pendukung' => $value,
            ]);
        }

        // peserta
        foreach ($request->peserta as $key => $value) {
            PesertaRaker::create([
                'id' => Id::generate(new PesertaRaker()),
                'id_raker' => $raker->id,
                'id_pegawai_perusahaan' => $value,
            ]);
        }

        // notulen
        $pegawaiPerusahaan = PegawaiPerusahaan::find($request->notulen);
        $notulen = NotulenRaker::create([
            'id' => Id::generate(new NotulenRaker()),
            'id_raker' => $raker->id,
            'username' => $pegawaiPerusahaan->nip_pegawai,
        ]);
        // end notulen

        return redirect()->route('sb_permohonan_rapat.index')->withInfo('Berhasil menambahkan data permohonan rapat baru');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $raker = $this->getSekretarisBidang()->raker->find($id);
        if (isset($raker)) {
            $ruangan = Ruangan::all();
            $pegawai = PegawaiPerusahaan::orderBy('nama_pegawai', 'asc')->get();
            $listFasilitas = ListFasilitas::all();
            $peserta = [];
            foreach ($raker->pesertaRaker as $key => $value) {
                $peserta[] = $value->id_pegawai_perusahaan;
            }
            // $peserta = json_encode($peserta);
            $fasilitas = [];
            $fasilitasLain = '';
            foreach ($raker->fasilitasPendukungRaker as $key => $value) {
                if (ListFasilitas::where('fasilitas', $value->fasilitas_pendukung)->count() > 0) {
                    $fasilitas[] = $value->fasilitas_pendukung.'';
                } else {
                    $fasilitasLain .= ','.$value->fasilitas_pendukung;
                }
            }
            // $fasilitas = json_encode($fasilitas);
            $fasilitasLain = $fasilitasLain != '' ? substr($fasilitasLain, 1) : '';

            return view('sekretaris_bidang.permohonan_rapat.update', compact('raker', 'ruangan', 'pegawai', 'fasilitas', 'peserta', 'listFasilitas', 'fasilitasLain'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $raker = $this->getSekretarisBidang()->raker->find($id);
        if (!isset($raker)) {
            return redirect()->back()->withInfo('Data tidak ditemukan');
        }
        $valid = Validator::make($request->all(), [
            'ruangan' => ['required', 'numeric'],
            'nama_rapat' => ['required', 'string'],
            'tanggal_jam_masuk' => ['required'],
            'tanggal_jam_keluar' => ['required'],
            'jumlah_peserta' => ['required', 'numeric', 'string'],
            'peserta' => ['required'], // id_pegawai
            'fasilitas' => ['required'],
            'notulen' => ['required', 'numeric'], // id_pegawai
            'deskripsi' => ['required', 'string'],
        ]);

        $valid->after(function ($validator) use ($request, $raker) {
            if (isset($request->tanggal_jam_masuk) && isset($request->tanggal_jam_keluar) && isset($request->ruangan) && isset($request->jumlah_peserta) && $request->notulen && $request->peserta) {
                $raker->update([
                    'tanggal_jam_masuk_raker' => null,
                    'tanggal_jam_keluar_raker' => null,
                ]);

                $waktuMasukRaker = $request->tanggal_jam_masuk;
                $waktuKeluarRaker = $request->tanggal_jam_keluar;
                $idRungan = $request->ruangan;
                $jumlah_peserta = $request->jumlah_peserta;

                if (!RakerValidation::checkWaktuKosong($waktuMasukRaker, $waktuKeluarRaker, $idRungan)) {
                    $waktuMasukRaker = str_replace('T', ' ', $waktuMasukRaker);
                    $waktuKeluarRaker = str_replace('T', ' ', $waktuKeluarRaker);
                    $error = "Ruang telah terpakai pada waktu {$waktuMasukRaker} sampai {$waktuKeluarRaker}";
                    $validator->errors()->add('tanggal_jam_masuk', $error);
                }

                $nowdatetime = strtotime(date('Y-m-d H:i'));
                if (strtotime($waktuMasukRaker) < $nowdatetime) {
                    $error = ' Tidak dapat melakukan raker kurang dari waktu sekarang';
                    $validator->errors()->add('tanggal_jam_masuk', $error);
                }

                if (strtotime($waktuKeluarRaker) < strtotime($waktuMasukRaker)) {
                    $waktuMasukRaker = str_replace('T', ' ', $waktuMasukRaker);
                    $waktuKeluarRaker = str_replace('T', ' ', $waktuKeluarRaker);
                    $error = " Tidak dapat melakukan raker dari rentang dari {$waktuMasukRaker} sampai {$waktuKeluarRaker}";
                    $validator->errors()->add('tanggal_jam_keluar', $error);
                }

                if (!RakerValidation::checkKapasitasRuangan($idRungan, $jumlah_peserta)) {
                    $ruangan = Ruangan::find($idRungan);
                    $error = " Kapasitas maksimal ruangan {$ruangan->jumlah_peserta} ";
                    $validator->errors()->add('jumlah_peserta', $error);
                }

                $notulen = $request->notulen;
                $peserta = $request->peserta;

                if (!in_array($notulen, $peserta)) {
                    $validator->errors()->add('notulen', 'Harus merupakan bagian dari peserta yang di inputkan sebelumnya');
                }

                if (count($peserta) > $jumlah_peserta) {
                    $validator->errors()->add('peserta', 'Pastikan peserta tidak lebih dari inputan jumlah peserta sebelumnya');
                }
            }
        });

        if ($valid->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($valid)
                    ->withInput();
        }

        $data = [
            'id_sekretaris_bidang' => $this->getSekretarisBidang()->id,
            'id_ruangan' => $request->get('ruangan', $raker->id_ruangan),
            'nama_raker' => $request->get('nama_rapat', $raker->nama_raker),
            'tanggal_jam_masuk_raker' => $request->get('tanggal_jam_masuk', $raker->tanggal_jam_masuk_raker),
            'tanggal_jam_keluar_raker' => $request->get('tanggal_jam_keluar', $raker->tanggal_jam_keluar_raker),
            'jumlah_peserta_raker' => $request->get('jumlah_peserta', $raker->jumlah_peserta_raker),
            'deskripsi_raker' => $request->get('deskripsi', $raker->deskripsi_raker),
        ];

        $raker->update($data);

        if (isset($request->fasilitas)) {
            foreach ($raker->fasilitasPendukungRaker as $key => $value) {
                $value->delete();
            }
            foreach ($request->fasilitas as $key => $value) {
                FasilitasPendukungRaker::create([
                    'id' => Id::generate(new FasilitasPendukungRaker()),
                    'id_raker' => $raker->id,
                    'fasilitas_pendukung' => $value,
                ]);
            }
        }

        if (isset($request->peserta)) {
            foreach ($raker->pesertaRaker as $key => $value) {
                $value->delete();
            }
            foreach ($request->peserta as $key => $value) {
                PesertaRaker::create([
                    'id' => Id::generate(new PesertaRaker()),
                    'id_raker' => $raker->id,
                    'id_pegawai_perusahaan' => $value,
                ]);
            }
        }

        if (isset($request->notulen)) {
            $raker->notulenRaker->delete();
            $pegawaiPerusahaan = PegawaiPerusahaan::find($request->notulen);
            $notulen = NotulenRaker::create([
                'id_raker' => $raker->id,
                'username' => $pegawaiPerusahaan->nip_pegawai,
            ]);
        }

        return redirect()->route('sb_kehadiran_rapat.index')->withInfo('Berhasil mengedit data permohonan rapat baru');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $raker = $this->getSekretarisBidang()->raker->find($id);
        if (isset($raker)) {
            $raker->delete();

            return redirect()->route('sb_permohonan_rapat.index')->withSuccess('Hapus berhasil ');
        }
    }
}
