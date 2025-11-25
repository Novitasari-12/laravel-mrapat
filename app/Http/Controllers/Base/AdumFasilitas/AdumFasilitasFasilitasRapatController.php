<?php

namespace App\Http\Controllers\Base\AdumFasilitas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ListFasilitas;
use App\MyLibraries\Generate\Id;

class AdumFasilitasFasilitasRapatController extends Controller
{
    private function myRequestData($request, $model = [])
    {
        $model = $model != null ? $model : $request;
        return [
            'fasilitas' => $request->get('fasilitas', $model->fasilitas),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fasilitas = ListFasilitas::all();
        return view('adum_fasilitas.fasilitas_rapat.index', compact('fasilitas'));
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
            'fasilitas' => ['required'],
        ]);
        $data = $this->myRequestData($request);
        $data['id'] = Id::generate(new ListFasilitas());
        $ruangan = ListFasilitas::create($data);
        return redirect()->route('ad_fasilitas_rapat.index')->withSuccess('Berhasil menambahkan bidang baru');
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
        $fasilitas = ListFasilitas::find($id);
        if (isset($fasilitas)) {
            $fasilitas->delete();
            return redirect()->back()->withSuccess('Berhasil hapus data fasilitas');
        }
        return redirect()->back()->withDanger('Tidak berhasil hapus data fasilitas');
    }
}
