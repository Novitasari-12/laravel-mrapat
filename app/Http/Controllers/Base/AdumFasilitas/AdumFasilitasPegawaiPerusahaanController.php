<?php

namespace App\Http\Controllers\Base\AdumFasilitas;


use Illuminate\Http\Request;
use App\Models\PegawaiPerusahaan;
use App\Http\Controllers\Controller;
use App\MyLibraries\Generate\Id;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class AdumFasilitasPegawaiPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawaiPerusahaan = PegawaiPerusahaan::all();
        return view('adum_fasilitas.pegawai.index', compact('pegawaiPerusahaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adum_fasilitas.pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->get('with', null) == 'form') {

            $request->validate([
                "nip_pegawai" => ['required', 'unique:pegawai_perusahaan,nip_pegawai'],
                "nama_pegawai" => ['required'],
                "unit_pegawai" => ['required'],
                "bidang_pegawai" => ['required'],
                "email_pegawai" => ['required', 'email'],
                "no_telpon" => ['required', 'unique:pegawai_perusahaan,no_telpon', 'numeric'],
                "password" => ['required', 'confirmed']
            ]);

            $data_create = $request->only([
                "nip_pegawai",
                "nama_pegawai",
                "unit_pegawai",
                "bidang_pegawai",
                "email_pegawai",
                "no_telpon",
                "password"
            ]);

            $data_create['id'] = Id::generate(new PegawaiPerusahaan());
            $data_create['password'] = Hash::make($data_create['password']);

            PegawaiPerusahaan::create($data_create);

            return redirect()->route('ad_pegawai_perusahaan.index')->withSuccess('Berhasil menambahkan data pegawai perusahaan');
        } else {
            $dataPegawai = $request->pegawai;
            $err = [];
            foreach ($dataPegawai as $key => $value) {
                $dataCreate = [
                    'id' => Id::generate(new PegawaiPerusahaan()),
                    'nip_pegawai' => $value['NIP'],
                    'nama_pegawai' => $value['NAMA'],
                    'bidang_pegawai' => $value['BIDANG'],
                    'unit_pegawai' => $value['UNIT'],
                    'email_pegawai' => $value['EMAIL'],
                    'no_telpon' => $value['TELPON'],
                ];
                try {
                    $pegawaiPerusahaan = PegawaiPerusahaan::updateOrCreate($dataCreate);
                } catch (\Illuminate\Database\QueryException $exception) {
                    $err[] = [
                        'pegawai' => $dataCreate['nama_pegawai'],
                        'err' => $exception->errorInfo,
                    ];
                }
            }
            return response()->json([
                'status' => true,
                'msg' => 'success',
                'err' => $err
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pegawai_perusahaan = PegawaiPerusahaan::find($id);

        return view('adum_fasilitas.pegawai.edit', compact('pegawai_perusahaan'));
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
        $pegawai_perusahaan = PegawaiPerusahaan::find($id);

        $request->validate([
            "nip_pegawai" => ['required', 'unique:pegawai_perusahaan,nip_pegawai,' . $pegawai_perusahaan->nip_pegawai . ',nip_pegawai'],
            "nama_pegawai" => ['required'],
            "unit_pegawai" => ['required'],
            "bidang_pegawai" => ['required'],
            "email_pegawai" => ['required', 'email'],
            "no_telpon" => ['required', 'unique:pegawai_perusahaan,no_telpon,' . $pegawai_perusahaan->id, 'numeric'],
            "password" => ['confirmed']
        ]);

        $data_update = $request->only([
            "nama_pegawai",
            "unit_pegawai",
            "bidang_pegawai",
            "email_pegawai",
            "no_telpon",
        ]);

        if ($request->nip_pegawai != $pegawai_perusahaan->nip_pegawai) {
            $data_update['nip_pegawai'] = $request->nip_pegawai;
        }
        if ($request->get('password', false)) {
            $data_update['password'] = Hash::make($data_update['password']);
        }
        $pegawai_perusahaan->update($data_update);

        return redirect()->route('ad_pegawai_perusahaan.index')->withSuccess('Berhasil mengedit data pegawai perusahaan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pegawaiPerusahaan = PegawaiPerusahaan::find($id);
        if (isset($pegawaiPerusahaan)) {
            $pegawaiPerusahaan->delete();
            return redirect()->route('ad_pegawai_perusahaan.index')->withInfo('BERHASIL HASPU DATA');
        }
        return redirect()->back()->withInfo('DATA HAPUS TIDAK ADA ');
    }
}
