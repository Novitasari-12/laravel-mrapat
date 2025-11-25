<?php

use App\Http\Controllers\Base\Absensi\AbsensiController;
use App\Http\Controllers\Base\AdumFasilitas\AdumFasilitasController;
use App\Http\Controllers\Base\AdumFasilitas\AdumFasilitasFasilitasRapatController;
use App\Http\Controllers\Base\AdumFasilitas\AdumFasilitasInformasiGambarController;
use App\Http\Controllers\Base\AdumFasilitas\AdumFasilitasPegawaiPerusahaanController;
use App\Http\Controllers\Base\AdumFasilitas\AdumFasilitasPersetujuanRapatController;
use App\Http\Controllers\Base\AdumFasilitas\AdumFasilitasRuanganRapatController;
use App\Http\Controllers\Base\AdumFasilitas\AdumFasilitasSekretarisBidangController;
use App\Http\Controllers\Base\JadwalRapatController;
use App\Http\Controllers\Base\Notulen\NotulenController;
use App\Http\Controllers\Base\Notulen\NotulenHasilRapatController;
use App\Http\Controllers\Base\Peserta\PesertaController;
use App\Http\Controllers\Base\SekretarisBidang\SekretarisBidangController;
use App\Http\Controllers\Base\SekretarisBidang\SekretarisBidangKehadiranRapatController;
use App\Http\Controllers\Base\SekretarisBidang\SekretarisBidangKesimpulanRapatController;
use App\Http\Controllers\Base\SekretarisBidang\SekretarisBidangPermohonanRapatController;
use App\Http\Controllers\Base\SekretarisBidang\SekretarisBidangPersetujuanRapatController;
use App\Http\Controllers\Base\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('jadwal_rapat.index');
});

Route::get('/login', [UserController::class, 'loginIndex'])->name('login.index');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/reset_password', [UserController::class, 'resetPasswordIndex'])->name('reset_password.index');
Route::post('/reset_password', [UserController::class, 'resetPassword'])->name('reset_password');
Route::get('/replace_password/{remember_token}/{email}', [UserController::class, 'replacePasswordIndex'])->name('replace_password.index');
Route::post('/replace_password/{remember_token}/{email}', [UserController::class, 'replacePassword'])->name('replace_password');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'role:sekretaris_bidang']], function () {
    Route::group(['prefix' => 'sekretaris_bidang'], function () {
        Route::get('/', [SekretarisBidangController::class, 'index'])->name('sekretaris_bidang.index');
        Route::resource('/sb_permohonan_rapat', SekretarisBidangPermohonanRapatController::class);
        Route::post('/sb_permohonan_rapat/{id_rapat}/pengajuan', [SekretarisBidangPermohonanRapatController::class, 'pengajuan'])->name('sb_permohonan_rapat.pengajuan');
        Route::delete('/sb_permohonan_rapat/{id_persetujuanRaker}/batal_pengajuan', [SekretarisBidangPermohonanRapatController::class])->name('sb_permohonan_rapat.batal_pengajuan');
        Route::resource('/sb_persetujuan_rapat', SekretarisBidangPersetujuanRapatController::class);
        Route::resource('/sb_kesimpulan_rapat', SekretarisBidangKesimpulanRapatController::class);
        Route::post('/sb_kesimpulan_rapat/{id_notulen}/publish', [SekretarisBidangKesimpulanRapatController::class, 'publish'])->name('sb_kesimpulan_rapat.publish');
        Route::resource('/sb_kehadiran_rapat', SekretarisBidangKehadiranRapatController::class);
        Route::get('sb_kehadiran_rapat/{id_rapat}/detail', [SekretarisBidangKehadiranRapatController::class, 'detail'])->name('sb_kehadiran_rapat.detail');
        Route::get('/sb_change_profile', [SekretarisBidangController::class, 'changeProfileIndex'])->name('sb_change_profile.index');
        Route::post('/sb_change_profile', [SekretarisBidangController::class, 'changeProfile'])->name('sb_change_profile');
    });
});

Route::group(['middleware' => ['auth', 'role:adum_fasilitas']], function () {
    Route::group(['prefix' => 'adum_fasilitas'], function () {
        Route::get('/', [AdumFasilitasController::class, 'index'])->name('adum_fasilitas.index');
        Route::resource('/ad_ruangan_rapat', AdumFasilitasRuanganRapatController::class);
        Route::resource('/ad_fasilitas_rapat', AdumFasilitasFasilitasRapatController::class);
        Route::resource('/ad_persetujuan_rapat', AdumFasilitasPersetujuanRapatController::class);
        Route::resource('/ad_sekretaris_bidang', AdumFasilitasSekretarisBidangController::class);
        Route::resource('/ad_pegawai_perusahaan', AdumFasilitasPegawaiPerusahaanController::class);
        Route::get('/ad_change_profile', [AdumFasilitasController::class, 'changeProfileIndex'])->name('ad_change_profile.index');
        Route::post('/ad_change_profile', [AdumFasilitasController::class, 'changeProfile'])->name('ad_change_profile');
        Route::resource('informasi_gambar', AdumFasilitasInformasiGambarController::class);
    });
});

Route::group(['prefix' => 'notulen'], function () {
    Route::get('/login', [NotulenController::class, 'loginIndex'])->name('notulen.index.login');
    Route::post('/login', [NotulenController::class, 'login'])->name('notulen.login');
    Route::get('/logout', [NotulenController::class, 'logout'])->name('notulen.logout');
    Route::resource('/ntln_hasil_rapat', NotulenHasilRapatController::class);
});

Route::group(['prefix' => 'absensi'], function () {
    Route::get('/', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/', [AbsensiController::class, 'ambilAbsensi'])->name('absensi.ambilAbsensi');
});

Route::group(['prefix' => 'peserta'], function () {
    Route::get('/change_password', [PesertaController::class, 'index'])->name('peserta.change_password.index');
    Route::post('/change_password', [PesertaController::class, 'change_password'])->name('peserta.change_password');
});

Route::group(['prefix' => 'jadwal_rapat'], function () {
    Route::get('/', [JadwalRapatController::class, 'index'])->name('jadwal_rapat.index');
    Route::get('/layar_penuh', [JadwalRapatController::class, 'layar_penuh'])->name('jadwal_rapat.layar_penuh');
    Route::get('/info', [JadwalRapatController::class, 'info'])->name('jadwal_rapat.info');
    Route::get('/show', [JadwalRapatController::class, 'show'])->name('jadwal_rapat.show');
});
