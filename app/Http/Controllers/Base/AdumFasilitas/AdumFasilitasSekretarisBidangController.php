<?php

namespace App\Http\Controllers\Base\AdumFasilitas;

use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;
use App\Models\SekretarisBidang;
use App\Http\Controllers\Controller;
use App\MyLibraries\Generate\Id;
use Illuminate\Support\Facades\Hash;

class AdumFasilitasSekretarisBidangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sekretaris = SekretarisBidang::all();
        return view('adum_fasilitas.sekretaris_bidang.index', compact('sekretaris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adum_fasilitas.sekretaris_bidang.create');
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
            'email' => ['required', 'email', 'unique:users'],
            'bidang' => ['required', 'string'],
            'nama' => ['required', 'string'],
            'password' => ['required', 'confirmed']
        ]);
        $level = Level::where('level', 'sekretaris_bidang')->first()->id;
        if (!isset($level)) {
            return redirect()->back()->withDanger('Data User level tidak ditemukan');
        }

        $userCreate = [
            'id' => Id::generate(new User()),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status_user' => 1,
            'id_level' => $level,
        ];

        $user = User::create($userCreate);
        if (isset($user)) {
            $sekretarisBidang = SekretarisBidang::create([
                'id' => Id::generate(new SekretarisBidang()),
                'id_user' => $user->id,
                'bidang_sekretaris' => $request->bidang,
                'nama_sekretaris' => $request->nama,
            ]);

            return redirect()->route('ad_sekretaris_bidang.index')->withSuccess('Berhasil membuat aku sekretaris bidang');
        }
        return redirect()->route('ad_sekretaris_bidang.index')->withDanger('Data User tidak ditemukan');
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
        $sekretaris = SekretarisBidang::find($id);
        if (isset($sekretaris)) {
            return view('adum_fasilitas.sekretaris_bidang.update', compact('sekretaris'));
        }
        return redirect()->route('ad_sekretaris_bidang.index')->withDanger('Data User tidak ditemukan');
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
        $this->validate($request, [
            'email' => ['email'],
            'bidang' => ['string'],
            'password' => ['confirmed'],
            'nama' => ['string'],
        ]);
        $sekretaris_bidang = SekretarisBidang::find($id);
        if(isset($request->email)) if(
            $sekretaris_bidang->user->email != $request->email && 
            User::where('email', $request->email)->count() > 0
        ) return redirect()->back()->withDanger('Maaf, Email telah ada sebelumnya');
        if (isset($sekretaris_bidang)) {
            $user = $sekretaris_bidang->user;
            $dataUser = [
                'email' => $request->get('email', $user->email),
            ];
            // jika adum fasilitas menginputkan password 
            if ($request->password != null) $dataUser['password'] = Hash::make($request->password) ;
            $user->update($dataUser);
            if (isset($user)) {
                $dataSekretarisBidang = [
                    'nama_sekretaris' => $request->get('nama', $sekretaris_bidang->nama_sekretaris),
                    'bidang_sekretaris' => $request->get('bidang', $sekretaris_bidang->bidang_sekretaris),
                ];
                $sekretaris_bidang->update($dataSekretarisBidang);
            }
            return redirect()->route('ad_sekretaris_bidang.index')->withSuccess('Berhasil update data akun sekretaris bidang ');
        }
        return redirect()->route('ad_sekretaris_bidang.index')->withDanger('Data User tidak ditemukan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sekretaris_bidang = SekretarisBidang::find($id);
        if (isset($sekretaris_bidang)) {
            $user = $sekretaris_bidang->user;
            $user->delete();
            return redirect()->route('ad_sekretaris_bidang.index')->withSuccess('Berhasil hapus data akun sekretaris bidang ');
        }
        return redirect()->route('ad_sekretaris_bidang.index')->withDanger('Data User tidak ditemukan');
    }
}
