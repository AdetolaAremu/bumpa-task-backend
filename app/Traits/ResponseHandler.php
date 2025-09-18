<?php

namespace App\Traits;

trait ResponseHandler
{
    public function successResponse($message, $data, $statusCode=200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public function errorResponse(string $message, int $statusCode = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }
}
