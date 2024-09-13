<?php

use Illuminate\Http\JsonResponse;

function json($data = [], $status = 200, array $headers = [], $options = 0): JsonResponse
{
    return response()->json($data, $status, $headers, $options);
}