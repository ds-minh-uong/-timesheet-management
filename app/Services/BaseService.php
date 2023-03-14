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

    public function create($params)
    {
        return $this->model->create($params);
    }

    public function update($model, $params)
    {
//        $model = $this->model->find($id);
        $model->update($params);

        return $model;
    }

    public function delete($id)
    {
        $item = $this->find($id);

        return $item ? $item->delete() : true;
    }

    public function find($id, $with = null)
    {
        $query = $this->model;
        if ($with) {
            $query = $query->with($with);
        }

        return $query->find($id);
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
