<?php

namespace App\Http\Controllers\Base\Notulen;

use App\Models\NotulenRaker;
use Illuminate\Http\Request;
use App\Mail\UserNotification;
use App\Http\Controllers\Controller;
use App\MyLibraries\SendMail\Mail as SendMailMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class NotulenHasilRapatController extends Controller
{

    private function ss($key){
        if(isset(Session::all()[$key])){
            return Session::all()[$key] ;
        }
        return 0 ;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = $this->ss('auth_notulen') ;
        if(isset($auth)){
            $notulen = NotulenRaker::find($this->ss('auth_notulen'));
            if ($this->ss('auth_login_notulen') && isset($notulen)) {
                return view('notulen.hasil_rapat.index', compact('notulen'));
            }
        }
        return redirect()->route('notulen.login');
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
        $auth = $this->ss('auth_notulen');
        if (!isset($auth)) {
            return redirect()->route('notulen.login');
        }
        $notulen = NotulenRaker::find($this->ss('auth_notulen'));
        if(isset($notulen)){
            if(!$notulen->status_tulis){
                return response([
                    'err' => 'Tidak dapat melakukan edit hasil rapat, segera beritahu admin untuk mengactivekannya kembali'
                ], 400);
            }
            $notulen->update([
                'hasil_raker' => $request->get('hasil_raker', $notulen->hasil_raker)
            ]);
        }
        if(isset($request->publish)){
            $notulen->update([
                'status_tulis' => 0,
            ]);

            // send ke email hasil rapat
            foreach ($notulen->raker->pesertaRaker as $key => $value) {
                $pegawai = $value->pegawaiPerusahaan;
                if(env('SMTP')){
                    Mail::to($pegawai->email_pegawai)->send(new UserNotification('mail.send_hasil_raker', [
                        "notulen" => $notulen,
                        "pegawai" => $pegawai,
                        "raker" => $notulen->raker,
                        "peserta" => $notulen->raker->pesertaRaker,
                    ]));
                } else {
                    (new SendMailMail([
                        'title' => env('MAIL_FROM_NAME'),
                        'to' => $pegawai->email_pegawai,
                        'subject' => 'HASIL RAPAT',
                    ]))->send('mail.send_hasil_raker', [
                        "notulen" => $notulen,
                        "pegawai" => $pegawai,
                        "raker" => $notulen->raker,
                        "peserta" => $notulen->raker->pesertaRaker,
                    ]);
                }
                
                
            }
        }   
        return response([
            'msg' => 'Tersimpan'
        ],200);
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
