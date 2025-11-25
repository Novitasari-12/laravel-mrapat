<?php 
namespace App\MyLibraries\RakerValidation;

use App\Models\PesertaRaker;
use App\Models\Raker;
use App\Models\Ruangan;

class RakerValidation {

    public static $ruangan ;
    public static $raker ;
    public static $peserta_raker ;

    public static function isRuangan($id_ruangan){
        self::$ruangan = Ruangan::find($id_ruangan);
        return isset(self::$ruangan) ;
    }    

    public static function checkKapasitasRuangan($id_ruangan, $kapasitas){
        if(self::isRuangan($id_ruangan)){
            return $kapasitas <= self::$ruangan->kapasitas_ruangan ;
        } else {
            return false ;
        }
    }

    public static function checkPakaiRuangan($id_ruangan){
        if(self::isRuangan($id_ruangan)){
            self::$raker = Raker::where('id_ruangan', $id_ruangan)->get();
            return self::$raker->count() > 0 ;
        } else {
            return false ;
        }
    }

    public static function checkWaktuPakaiRuangan($waktuInputRaker, $id_ruangan){
        if(self::checkPakaiRuangan($id_ruangan)){
            $waktuInputRaker = strtotime($waktuInputRaker) ;
            foreach (self::$raker as $key => $value) {
                $waktuRakerSelesaiDB = strtotime($value['tanggal_jam_keluar_raker']);
                $waktuSelisih = $waktuInputRaker - $waktuRakerSelesaiDB ;
                if($waktuSelisih >= 0){
                    return true ;
                    break;
                }
            }
            return false ;
        } else {
            return false;
        }
    }

    public static function checkWaktuKosong($tanggal_jam_masuk_raker, $tanggal_jam_keluar_raker, $id_ruangan){
        self::$raker = Raker::where('id_ruangan', $id_ruangan)
        ->where(function($query) use($tanggal_jam_masuk_raker, $tanggal_jam_keluar_raker){
            $query->where(function ($query) use ($tanggal_jam_masuk_raker, $tanggal_jam_keluar_raker) {
                $query->where('tanggal_jam_masuk_raker', '>', $tanggal_jam_masuk_raker)
                    ->where('tanggal_jam_masuk_raker', '<', $tanggal_jam_keluar_raker);
            })
            ->orWhere(function ($query) use ($tanggal_jam_masuk_raker, $tanggal_jam_keluar_raker) {
                $query->where('tanggal_jam_keluar_raker', '>', $tanggal_jam_masuk_raker)
                    ->where('tanggal_jam_keluar_raker', '<', $tanggal_jam_keluar_raker);
            })
            ->orWhere(function ($query) use ($tanggal_jam_masuk_raker, $tanggal_jam_keluar_raker) {
                $query->where('tanggal_jam_masuk_raker', '<=', $tanggal_jam_masuk_raker)
                    ->where('tanggal_jam_keluar_raker', '>=', $tanggal_jam_keluar_raker);
            });
        })
        ->count();

        return self::$raker <= 0 ;

        // select * from `raker` where `id_adum_fasilitas` = 1 and `id_ruangan` = 3 and ((`tanggal_jam_masuk_raker` > '2020-03-09 08:23' AND `tanggal_jam_masuk_raker` < '2020-03-00 09:14') or (`tanggal_jam_keluar_raker` > '2020-03-09 08:23' AND `tanggal_jam_keluar_raker` < '2020-03-00 09:14' )) OR (tanggal_jam_keluar_raker < '2020-03-09 08:23' and tanggal_jam_masuk_raker > '2020-03-00 09:14')
    }

    public static function checkWaktuKeluar($id_adum_fasiltias, $tanggal_jam_keluar_raker, $id_ruangan){
        self::$raker = Raker::where('id_adum_fasilitas', $id_adum_fasiltias)->where('tanggal_jam_masuk_raker', '', $tanggal_jam_keluar_raker)->where('id_ruangan', $id_ruangan)->count();
        return self::$raker <= 0 ; //sama dengan 0 
    }

    public static function isPeserta($id_raker){
        self::$raker = Raker::find($id_raker);
        return isset(self::$raker);
    }

    public static function checkPeserta($id_peserta_raker, $tanggal_jam_masuk_raker){
        // date_default_timezone_set('Asia/Jakarta');
        // $waktuSekarang = date('Y-m-d H:i');
        self::$raker = Raker::where('tanggal_jam_masuk_raker', '>=', $tanggal_jam_masuk_raker)->get();
        self::$peserta_raker =  self::$raker->find($id_peserta_raker);
        if(isset(self::$peserta_raker)){
            return true ;
        } else {
            return false ;
        }
    }

}