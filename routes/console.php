<?php

use App\Mail\UserNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fresh:dev', function () {
    Artisan::call('db:wipe');
    Artisan::call('migrate');
    Artisan::call('db:seed');
});

Artisan::command('sendmail', function () {
    try {
        Mail::to('lxafdal@gmail.com')->send(new UserNotification('mail.send_hasil_raker', [
            "notulen" => (object) [
                'hasil_raker' => 'hasil_raker'
            ],
            "pegawai" => (object) [
                'nama_pegawai' => 'nama_pegawai'
            ],
            "raker" => (object) [
                'nama_raker' => 'nama_raker',
                'ruangan' => (object) [
                    'nama_ruangan' => 'nama_ruangan',
                ],
                'tanggal_jam_masuk_raker' => 'tanggal_jam_masuk_raker',
                'tanggal_jam_keluar_raker' => 'tanggal_jam_keluar_raker',
                'jumlah_peserta_raker' => 'jumlah_peserta_raker',
                'deskripsi_raker' => 'deskripsi_raker',
            ],
            "peserta" => null,
        ]));
    } catch (\Throwable $th) {
        throw $th;
    }
});
