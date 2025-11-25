<?php

namespace App\Http\Controllers\Base\AdumFasilitas;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller as MainController;
use App\Models\PersetujuanRaker;
use App\Models\Raker;

class AdumFasilitasController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datenow = date('Y-m-d');
        $raker = Raker::orderBy('created_at', 'desc')->where('tanggal_jam_masuk_raker', '>=', $datenow)->get();
        $rakerNow = [] ;
        foreach ($raker as $key => $value) {
            if(isset($value->persetujuanRaker)){
                if ($value->persetujuanRaker->status_persetujuan_raker) {
                    $rakerNow[] = $value;
                }
            }
        }
        return view('adum_fasilitas.welcome', compact('rakerNow'));
    }

    public function changeProfileIndex(){
        return view('adum_fasilitas.profile');
    }
    
    public function changeProfile(Request $request){
        $user = auth()->user() ;
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['confirmed']
        ]);
        if($request->email != $user->email ){
            $this->validate($request, [
                'email' => ['required', 'email', 'unique:users']
            ]);
        }
        $user->update([
            'email' => $request->get('email', $user->email),
        ]);
        if(isset($request->password)){
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }
        return redirect()->back()->withSuccess('Berhasil update data profile') ;
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
        //
    }
}
