<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'ok' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    protected function respondWithTemplate($ok = false, $data = [], $msg = null, $statusCode = 200)
    {
        return response()->json([
            'ok' => $ok,
            'msg' => $msg,
            'data' => $data
        ], $statusCode);
    }
}
