<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SaveDataDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function getDocument($keyDocument)
    {
        $document = SaveDataDocument::getItem($keyDocument);
        if (!isset($document)) {
            return response([
                'err_msg' => 'data_not_found',
                'err' => ['Data yang dimaksut tidak tersedia'],
            ], 404);
        }

        $value = response(base64_decode($document->value));

        return $value->header('Content-Type', $document->mime_type);
    }

    public function postDocument(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nama' => ['required'],
            'document' => ['required', 'max:2048'],
        ]);
        if ($valid->fails()) {
            return response(['err_msg' => 'request_invalidate', 'err' => $valid->errors()]);
        }

        $link = SaveDataDocument::setItem($request->nama, $request->file('document'));

        return response([
            'msg' => ['berhasil menyimpan data'],
            'data' => $link,
        ]);
    }
}
