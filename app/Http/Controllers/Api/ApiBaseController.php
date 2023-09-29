<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiBaseController extends Controller
{
    /**
     * @param $result
     * @return JsonResponse
     */
    protected function returnJsonResponse($result): JsonResponse
    {
        if (is_array($result)) {
            return response()->json($result, 422);
        } else {
            return response()->json(['success' => $result], 200);
        }
    }
}
