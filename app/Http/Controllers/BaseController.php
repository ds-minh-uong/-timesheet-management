<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function __construct()
    {
//        $this->user = Auth::user();
    }

    public function respondError($message, $data)
    {
        return $this->respond([
            'data' => $data,
            'message' => $message,
            'status' => false
        ]);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondErrorWithMessage($message)
    {
        return $this->respond([
            'message' => $message,
            'status' => false
        ]);
    }

    /**
     * @param $nameObject
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($nameObject)
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respond([
            'message' => "Không tìm thấy " . $nameObject,
            "status" => false
        ]);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondSuccessWithStatus($data)
    {
        return $this->respond([
            'data' => $data,
            'status' => true
        ]);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondSuccess($data)
    {
        if (empty($data["status"])) {
            $data["status"] = true;
        }
        return $this->respond($data);
    }

    public function responseWithError($message)
    {
        return response()->json([
            'error' => $message
        ], $this->getStatusCode());
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondSuccessWithMessage($message)
    {
        return $this->respond([
            'message' => $message,
            "status" => true
        ]);
    }

    public function responseUnAuthorized($message = 'Unauthorized!')
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->responseWithError($message);
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

}
