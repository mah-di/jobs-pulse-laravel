<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function make(string $status = 'success', array|object|int|null $data = null, string|null $msg = null, array $extra = [], int $statusCode = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $msg,
            'data' => $data,
            ...$extra
        ], $statusCode);
    }
}
