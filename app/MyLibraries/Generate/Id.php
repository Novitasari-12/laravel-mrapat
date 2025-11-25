<?php

namespace App\MyLibraries\Generate;

class Id
{

    public static function generate($model)
    {
        $id = rand(100000, 999999);
        $dataIdCount = $model->where('id', $id)->count();
        if ($dataIdCount > 0) {
            return self::generate($model);
        }
        return $id;
    }
}
