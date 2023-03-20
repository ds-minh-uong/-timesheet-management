<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BaseService
{
    protected $model;
    public function __construct()
    {

    }

//    protected function  uploadFile($param, $field, $folder)
//    {
//        list($extension, $content) = explode(';', $param[$field]);
//        $tmpExtension = explode('/', $extension);
//        $fileName = Carbon::now()->timestamp . '.' . $tmpExtension[1];
//        $content = explode(',', $content)[1];
//        $test = Storage::put('public/' . $folder . '/' . $fileName, base64_decode($content));
//
//        return $fileName;
//    }
}
