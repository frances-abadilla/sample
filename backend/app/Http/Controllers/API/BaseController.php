<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\JsonResponse;

/**
 * Base for every API controller, so all answers share one format:
 *   success: { success: true,  data: ..., message: "..." }
 *   error:   { success: false, message: "...", data: {...optional details} }
 */
class BaseController extends Controller
{
    public function sendResponse($result, $message = '', $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => $message,
        ], $code);
    }

    public function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = ['success' => false, 'message' => $error];

        if (! empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
