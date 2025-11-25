<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InformasiGambar;

class BannerController extends Controller
{
    public function index()
    {
        $information_image = InformasiGambar::where('waktu_mulai_ditampilkan', '<=', date('Y-m-d H:i:s'))
            ->where('waktu_selesai_ditampilkan', '>=', date('Y-m-d H:i:s'))
            ->get();

        return response([
            'msg' => 'berhasil menampilkan banner',
            'data' => [
                'banner' => $information_image,
            ],
            'err' => null,
        ]);
    }
}
