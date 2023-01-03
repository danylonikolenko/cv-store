<?php

use App\Dto\Response\ResponseDto;
use Illuminate\Http\JsonResponse;

if (!function_exists('api_response')) {
    function api_response(ResponseDto $response): JsonResponse
    {
        $result = [
            'status' => $response->getStatus(),
            'result' => $response->getResult(),
        ];
        if ($response->getDescription()) {
            $result['description'] = $response->getDescription();
        }

        if ($response->getAdditionalParams()) {
            $result = array_merge($result, $response->getAdditionalParams());
        }

        return response()->json($result, $response->getStatusCode());
    }
}
