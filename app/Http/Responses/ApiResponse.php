<?php

    namespace App\Http\Responses;

    use Illuminate\Http\Exceptions\HttpResponseException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Log;

    class ApiResponse
    {
        public static function success(string $message, int $code, mixed $data): JsonResponse
        {
            Log::notice($message, (array) $data);

            $response = [
                'success' => true,
                'message' => $message,
                'data' => $data,
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
