<?php

namespace App\Http\Controllers\Base\Peserta;

use App\Http\Controllers\Controller as MainController;
use App\Models\PegawaiPerusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PesertaController extends MainController
{
    public function index()
    {
        return view('peserta_acara.change_password');
    }

    public function change_password(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nip' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password_lama' => ['required', 'string'],
            'password_baru' => ['required', 'string', 'confirmed'],
            'password_baru_confirmation' => ['required'],
        ]);

        if ($valid->fails()) {
            return redirect()
                    ->back()
                    ->withErrors($valid)
                    ->withInput();
        }

        $pegawaiPerusahaan = PegawaiPerusahaan::where('nip_pegawai', $request->nip)->where('email_pegawai', $request->email)->first();
        if (!isset($pegawaiPerusahaan)) {
            return redirect()->back()->withInput()->withDanger('Nip atau email pengawai tidak cocok');
        }

        if (!Hash::check($request->password_lama, $pegawaiPerusahaan->password)) {
            return redirect()->back()->withInput()->withDanger('Password lama tidak sesuai');
        }

        $pegawaiPerusahaan->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()->back()->withInfo('Berhasil mengubah password');
    }
}
