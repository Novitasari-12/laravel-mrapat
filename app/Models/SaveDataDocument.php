<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaveDataDocument extends Model
{
    protected $table = 'save_data_document';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'original_name',
        'mime_type',
        'value',
    ];

    public static function setItem($key, $fileRequest)
    {
        $originalName = $fileRequest->getClientOriginalName();
        $mimeType = $fileRequest->getClientMimeType();
        $valueDocument = file_get_contents($fileRequest);
        $data_item = [
            'key' => $key,
            'original_name' => $originalName,
            'mime_type' => $mimeType,
        ];

        $data_item['value'] = base64_encode($valueDocument);
        $setItem = SaveDataDocument::updateOrCreate($data_item);

        return SaveDataDocument::getDocument($key);
    }

    public static function getItem($key)
    {
        return SaveDataDocument::where('key', $key)->first();
    }

    public static function removeItem($key)
    {
        return SaveDataDocument::where('key', $key)->delete();
    }

    public static function getDocument($key)
    {
        return route('get.document', [$key]);
    }
}
