<?php

    namespace App\Http\Responses;

    use Illuminate\Http\Exceptions\HttpResponseException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class ApiResponse
    {
        public static function success(string $message, int $code, array $data): JsonResponse
        {
            Log::notice($message, $data);

            $response = [
                'success' => true,
                'data' => $data,
                'message' => $message,
            ];

            return response()->json($response, $code);
        }

        public static function error(string $message, int $code, array $data = []): JsonResponse
        {
            Log::error($message, $data);

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => $message,
                'code' => $code
            ]));
        }
    }
