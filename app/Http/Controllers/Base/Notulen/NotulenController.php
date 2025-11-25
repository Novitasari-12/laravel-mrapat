<?php

namespace App\Http\Controllers\Base\Notulen;

use App\Http\Controllers\Controller as MainController;
use App\Models\NotulenRaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NotulenController extends MainController
{
    public function loginIndex()
    {
        return view('auth.login-notulen');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $notulen = NotulenRaker::where('username', $request->username)->where('password', $request->password)->first();
        if (isset($notulen)) {
            Session::put('auth_login_notulen', true);
            Session::put('auth_notulen', $notulen->id);

            return redirect()->route('ntln_hasil_rapat.index');
        } else {
            return redirect()->route('notulen.login')->withDanger('Maaf, Login Gagal');
        }
    }

    public function logout()
    {
        Session::put('auth_login_notulen', false);
        Session::put('auth_notulen', 0);

        return redirect()->route('notulen.login');
    }
}
