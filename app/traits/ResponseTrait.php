<?php

namespace App\traits;

trait ResponseTrait
{

    public function success($data = null, $message = null, $code = 200)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
        ], $code);
    }
    public function successWithToken($data = null, $message = 'success', $code = 200, $token = null)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
            'token' => $token,
        ], $code);
    }

    public function error($message = null, $code = 500)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $code);
    }

}