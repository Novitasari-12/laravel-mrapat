<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PersetujuanRaker;
use App\MyLibraries\RequestValidation\RequestValidation;

class PersetujuanRapatController extends Controller
{
    public function batalPersetujuanRapat(Request $request)
    {

        return RequestValidation::valid([
            'request' => $request,
            'rule' => [
                'id_raker' => ['required', 'numeric'],
                'id_sekretaris_bidang' => ['required', 'numeric']
            ]
        ], function ($request) {
            $idRaker = $request->id_raker;
            $idSekretarisBidang = $request->id_sekretaris_bidang;

            $persetujuan = PersetujuanRaker::where('id_raker', $idRaker)->where('id_sekretaris_bidang', $idSekretarisBidang)->first();

            if (isset($persetujuan)) {
                $status_persetujuan = $persetujuan->status_persetujuan_raker == 1 ? 0 : 1;
                $persetujuan->update([
                    'status_persetujuan_raker' => $status_persetujuan,
                    'deskripsi_persetujuan_raker' => ''
                ]);
                return response([
                    'stat' => 1,
                    'data' => $persetujuan,
                    'msg' => 'data ditemukan'
                ]);
            }

            return response([
                'stat' => 0,
                'error' => ['data tidak ditemukan']
            ], 400);
        }, function ($err) {
            $response = [
                'status' => 0,
                'err' => RequestValidation::errMsg($err)
            ];
            return response($response, 400);
        });
    }
}
