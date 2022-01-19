<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * return response api
     */
    public static function returnResponse($status = "success", $message = "Successfully", $data = null, $status_code = 200): JsonResponse
    {
        return response()->json(['status' => $status, 'message' => $message, 'data' => $data], $status_code);
    }
}
