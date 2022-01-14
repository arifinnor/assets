<?php

namespace App\Helper;

trait BasicResponse
{
    public function success(array $data = [], int $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ], $code);
    }

    public function error(string $message = "error", int $code = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message

        ], $code);
    }
}
