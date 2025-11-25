<?php

namespace App\Http\Controllers\Base\AdumFasilitas;

use App\Http\Controllers\Controller;
use App\Mail\UserNotification;
use App\Models\PegawaiPerusahaan;
use App\Models\PersetujuanRaker;
use App\Models\Ruangan;
use App\MyLibraries\RakerValidation\RakerValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdumFasilitasPersetujuanRapatController extends Controller
{
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
        $yesPersetujuan = [];
        $noPersetujuan = [];
        $ruangan = Ruangan::all();

        foreach (PersetujuanRaker::orderBy('created_at', 'desc')->get() as $key => $value) {
            if ($value->status_persetujuan_raker) {
                $yesPersetujuan[] = $value;
            } else {
                $noPersetujuan[] = $value;
            }
        }

        return view('adum_fasilitas.persetujuan_rapat.index', compact('yesPersetujuan', 'noPersetujuan', 'ruangan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $persetujuan = PersetujuanRaker::find($id);

        $before_status_persetujuan = $persetujuan->status_persetujuan_raker;
        $raker = $persetujuan->raker;

        $valid = Validator::make($request->all(), [
            'ruangan' => ['numeric'],
            'deskripsi_persetujuan_raker' => ['string'],
            'status_persetujuan' => ['boolean'],
        ]);

        $valid->after(function ($validator) use ($request, $raker) {
            if (isset($request->ruangan)) {
                $id_ruangan = $request->get('ruangan', $raker->id_ruangan);
                // update ruangan kondisi
                if ($id_ruangan != $raker->id_ruangan) {
                    $ruangan = Ruangan::find($id_ruangan);
                    if (!RakerValidation::checkWaktuKosong($raker->tanggal_jam_masuk_raker, $raker->tanggal_jam_keluar_raker, $request->id_ruangan)) {
                        $waktuMasukRaker = str_replace('T', ' ', $raker->tanggal_jam_masuk_raker);
                        $waktuKeluarRaker = str_replace('T', ' ', $raker->tanggal_jam_keluar_raker);
                        $error = "Ruang telah terpakai pada waktu {$waktuMasukRaker} sampai {$waktuKeluarRaker}";
                        $validator->errors()->add('ruangan', $error);
                    }
                    if ($ruangan->kapasitas_ruangan < $raker->jumlah_peserta_raker) {
                        $error = "Kapasitas ruangan hanya tersedia {$ruangan->kapasitas_ruangan} ";
                        $validator->errors()->add('ruangan', $error);
                    }
                }
            }
        });

        if ($valid->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($valid)
                    ->withInput();
        }

        if (isset($request->deskripsi_persetujuan_raker)) {
            $persetujuan->update(['deskripsi_persetujuan_raker' => $request->deskripsi_persetujuan_raker]);

            return redirect()->back()->withInfo('Berhasil menambahkan keterangan permohonan rapat');
        }

        if (isset($request->ruangan)) {
            $ruangan = Ruangan::find($request->ruangan);

            $info_konfirmasi = "Ruang rapat dari {$raker->ruangan->nama_ruangan} telah di pindahkan ke {$ruangan->nama_ruangan} dengan kapasitas maksimal {$ruangan->kapasitas_ruangan}. ";

            $raker->update([
                'id_ruangan' => $request->get('ruangan', $raker->id_ruangan),
            ]);
            $persetujuan->update([
                'deskripsi_persetujuan_raker' => $info_konfirmasi.$request->get('deskripsi_persetujuan_raker', $persetujuan->deskripsi_persetujuan_raker),
            ]);

            return redirect()->back()->withInfo('Berhasil mengubah ruangan permohonan rapat');
        }

        if (isset($request->status_persetujuan)) {
            $pegawaiNotulen = PegawaiPerusahaan::where('nip_pegawai', $raker->notulenRaker->username)->first();
            if ($request->status_persetujuan) {
                $password_notulen = Str::random(10).$raker->notulenRaker->id;

                $raker->notulenRaker->update([
                    'password' => $password_notulen,
                ]);

                // send msg username and password in desc persetujuan rapat
                $persetujuan->update([
                    'deskripsi_persetujuan_raker' => "\nNOTULEN LOGIN URL : ".route('notulen.index.login')." \nUSERNAME : {$pegawaiNotulen->nip_pegawai} \nPASSWORD : {$password_notulen}",
                ]);
                // $persetujuan->update([
                //     'deskripsi_persetujuan_raker' => "{$persetujuan->deskripsi_persetujuan_raker}  \nNOTULEN LOGIN URL : ".route('notulen.index.login')." \nUSERNAME : {$pegawaiNotulen->nip_pegawai} \nPASSWORD : {$password_notulen}",
                // ]);

                // send email
                try {
                    Mail::to($pegawaiNotulen->email_pegawai)->send(new UserNotification('mail.undangan_notulen_raker', [
                        'pegawai' => $pegawaiNotulen,
                        'raker' => $raker,
                    ]));
                } catch (\Throwable $th) {
                    //throw $th;
                }
                // end send mail

                foreach ($raker->pesertaRaker as $key => $value) {
                    $pegawai = $value->pegawaiPerusahaan;
                    // send mail
                    try {
                        Mail::to($pegawai->email_pegawai)->send(new UserNotification('mail.undangan_raker', [
                            'pegawai' => $pegawai,
                            'raker' => $raker,
                        ]));
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    // end send mail
                }
            } else {
                $raker->notulenRaker->update([
                    'password' => null,
                ]);
                // msg persetujuan
                $persetujuan->deskripsi_persetujuan_raker = 'Belum ada persetujuan, '.$persetujuan->deskripsi_persetujuan_raker;
                $persetujuan->save();
                // end msg

                // send email
                if ($before_status_persetujuan) {
                    // send mail rapat di setujui -> notulen
                    try {
                        Mail::to($pegawaiNotulen->email_pegawai)->send(new UserNotification('mail.revisi_undangan_notulen_raker', [
                            'pegawai' => $pegawaiNotulen,
                            'raker' => $raker,
                        ]));
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    // end send mail

                    // send mail rapat di setujui -> peserta rapat
                    foreach ($raker->pesertaRaker as $key => $value) {
                        $pegawai = $value->pegawaiPerusahaan;
                        try {
                            Mail::to($pegawai->email_pegawai)->send(new UserNotification('mail.revisi_undangan_raker', [
                                'pegawai' => $pegawai,
                                'raker' => $raker,
                            ]));
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                    }
                }
            }

            $persetujuan->update(['status_persetujuan_raker' => $request->status_persetujuan]);

            return redirect()->back()->withInfo('Berhasil mengubah status persetujuan permohonan rapat');
        }

        return redirect()->back();
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
    }
}
