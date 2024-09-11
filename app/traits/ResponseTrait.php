<?php

namespace App\traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{

  
    protected function success($data, string $message = 'Operation successful', int $status = 200): JsonResponse
{
    return response()->json([
        'status' => 'success',
        'message' => $message,
        'data' => $data,
    ], $status);
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