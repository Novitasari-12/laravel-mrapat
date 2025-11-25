<?php

namespace App\Http\Controllers\Base\AdumFasilitas;

use App\Http\Controllers\Controller;
use App\Models\InformasiGambar;
use App\Models\SaveDataDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdumFasilitasInformasiGambarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $igambar = InformasiGambar::all();

        return view('adum_fasilitas.info_gambar.index', compact('igambar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adum_fasilitas.info_gambar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nama' => ['required'],
            'gambar' => ['required', 'image', 'max:2048'],
            'informasi_gambar' => ['required'],
            'waktu_mulai_ditampilkan' => ['required'],
            'waktu_selesai_ditampilkan' => ['required'],
        ]);

        if ($valid->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($valid)
                    ->withInput();
        }

        $data_create = $request->only(['nama', 'gambar', 'informasi_gambar', 'waktu_mulai_ditampilkan', 'waktu_selesai_ditampilkan']);
        $timestamp = strtotime(date('Y-m-d H:i:s'));
        $data_create['gambar'] = SaveDataDocument::setItem('informasi-gambar-'.$timestamp, $request->file('gambar'));
        InformasiGambar::create($data_create);

        return redirect()->route('informasi_gambar.index')->withSuccess('Berhasil menambahkan data informasi gambar');
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
        $igambar = InformasiGambar::find($id);
        if (!isset($igambar)) {
            redirect()->route('informasi_gambar.index')->withInfo('Data tidak ditemukan');
        }

        return view('adum_fasilitas.info_gambar.update', compact('igambar'));
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
        $valid = Validator::make($request->all(), [
            'nama' => ['required'],
            'gambar' => ['image', 'max:2048'],
            'informasi_gambar' => ['required'],
            'waktu_mulai_ditampilkan' => ['required'],
            'waktu_selesai_ditampilkan' => ['required'],
        ]);

        if ($valid->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($valid)
                    ->withInput();
        }

        $igambar = InformasiGambar::find($id);
        if (!isset($igambar)) {
            redirect()->route('informasi_gambar.index')->withInfo('Data tidak ditemukan');
        }

        $data_create = $request->only(['nama', 'informasi_gambar', 'waktu_mulai_ditampilkan', 'waktu_selesai_ditampilkan']);

        if (isset($request->gambar)) {
            SaveDataDocument::removeItem($igambar->gambar);
            $timestamp = strtotime(date('Y-m-d H:i:s'));
            $data_create['gambar'] = SaveDataDocument::setItem('informasi-gambar-'.$timestamp, $request->file('gambar'));
        }

        $igambar->update($data_create);

        return redirect()->route('informasi_gambar.index')->withSuccess('Berhasil mengupdate data informasi gambar');
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
        $igambar = InformasiGambar::find($id);
        if (!isset($igambar)) {
            redirect()->route('informasi_gambar.index')->withInfo('Data tidak ditemukan');
        }

        $igambar->delete();

        return redirect()->route('informasi_gambar.index')->withSuccess('Berhasil menghapus data informasi gambar');
    }
}
