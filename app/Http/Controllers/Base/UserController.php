<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Mail\UserNotification;
use App\MyLibraries\SendMail\Mail as SendMailMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('logout');
    }

    private function myRequestLogin($request, $model = [])
    {
        $model = $model != null ? $model : $request;

        return [
            'email' => $request->get('email', $model->email),
            'password' => $request->get('password', $model->password),
        ];
    }

    private function userRedirect()
    {
        $user = auth()->user();
        switch ($user->level->level) {
            case 'adum_fasilitas':
                return redirect()->route('adum_fasilitas.index');
                break;
            case 'sekretaris_bidang':
                return redirect()->route('sekretaris_bidang.index');
                break;
        }
    }

    public function loginIndex()
    {

        $user = Auth::user();

        if(isset($user)){
            $level = $user->level;
            if(isset($level)){
                $level_name = $level->level ;
                return redirect()->route("{$level_name}.index");
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);
        $attempt = $this->myRequestLogin($request);
        if (Auth::attempt($attempt)) {
            $user = auth()->user();
            $user->remember_token = Str::random(60);

            return $this->userRedirect();
        }

        return redirect()->back()->withDanger('Maaf, Login kamu gagal, silahkan cek username dan password kamu kembali');
    }

    public function resetPasswordIndex()
    {
        return view('auth.reset_password');
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
        ]);
        $user = User::where('email', $request->email)->first();
        if (!isset($user)) {
            return redirect()->back()->withDanger('Maaf, Email Tidak Tersedia');
        }
        $user->remember_token = Str::random(60);
        $user->save();

        if (env('SMTP')) {
            Mail::to($user)->send(new UserNotification('mail.reset_password', ['user' => $user]));
        // or
        } else {
            (new SendMailMail([
                'title' => env('MAIL_FROM_NAME'),
                'to' => $user->email,
                'subject' => 'RESET PASSWORD',
            ]))->send('mail.reset_password', ['user' => $user]);
        }

        return redirect()->back()->withInfo('Silahkan, Cek Email !');
    }

    public function replacePasswordIndex($remember_token, $email)
    {
        $user = User::where('email', $email)->where('remember_token', $remember_token)->first();
        if (!isset($user)) {
            return redirect()->route('login.index')->withDanger('Maaf, Tidak ada user yang sesuai');
        }

        return view('auth.replace_password', compact('user'));
    }

    public function replacePassword(Request $request, $remember_token, $email)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::where('email', $email)->where('remember_token', $remember_token)->first();
        $user->update([
            'remember_token' => '',
            'password' => Hash::make($request->password),
        ]);
        $redirect = redirect()->route('login.index');
        if (!isset($user)) {
            return $redirect->withDanger('Maaf, Tidak ada user yang sesuai');
        }

        return $redirect->withSuccess('Silahkan Login Kembali');
    }

    public function logout()
    {
        auth()->logout();
        $redirect = redirect()->route('login.index');

        return $redirect->withSuccess('Silahkan Login Kembali');
    }
}
