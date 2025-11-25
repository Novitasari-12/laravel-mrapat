<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NotulenRaker;
use App\MyLibraries\RequestValidation\RequestValidation;

class NotulenController extends Controller
{
    function batalPublishNotulen(Request $request){
        return RequestValidation::valid([ 'request' => $request, 'rule' => [
            'id' => ['required', 'numeric'],
            'id_raker' => ['required', 'numeric']
        ]], function($request){
            
            $notulen = NotulenRaker::where('id', $request->id)->where('id_raker', $request->id_raker)->first();

            if(isset($notulen)){

                $status_tulis = $notulen->status_tulis == 1 ? 0 : 1 ; 

                $notulen->update([
                    'status_tulis' => $status_tulis
                ]);

                return response([
                    'stat' => 1,
                    'data' => $notulen,
                    'msg' => 'berhasil'
                ]);
            }

            return response([
                'stat' => 0,
                'err' => ['data tidak ditemukan']
            ], 400);

        }, function($err) {
            return response([
                'stat' => 0,
                'err' => RequestValidation::errMsg($err)
            ], 400);
        });
    }
}
