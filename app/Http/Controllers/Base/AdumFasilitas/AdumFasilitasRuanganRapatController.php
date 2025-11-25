<?php

namespace App\Http\Controllers\Base\AdumFasilitas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\MyLibraries\Generate\Id;

class AdumFasilitasRuanganRapatController extends Controller
{
    private function myRequestData($request, $model = [])
    {
        $model = $model != null ? $model : $request;
        return [
            'nama_ruangan' => $request->get('nama_ruangan', $model->nama_ruangan),
            'kapasitas_ruangan' => $request->get('kapasitas_ruangan', $model->kapasitas_ruangan)
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruangan = Ruangan::all();
        return view('adum_fasilitas.ruang_rapat.index', compact('ruangan'));
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
        $this->validate($request, [
            'nama_ruangan' => ['required'],
            'kapasitas_ruangan' => ['required', 'numeric'],
        ]);
        $data = $this->myRequestData($request);
        $data['id'] = Id::generate(new Ruangan());
        $ruangan = Ruangan::create($data);
        return redirect()->route('ad_ruangan_rapat.index')->withSuccess('Berhasil menambahkan bidang baru');
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
        $ruangan = Ruangan::find($id);
        if (isset($ruangan)) {
            $ruangan->delete();
            return redirect()->back()->withSuccess('Berhasil hapus data ruangan');
        }
        return redirect()->back()->withDanger('Tidak berhasil hapus data ruangan');
    }
}
