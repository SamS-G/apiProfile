<?php

    namespace App\Http\Responses;

    use Illuminate\Http\Exceptions\HttpResponseException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class ApiResponse
    {
        public static function success($data = [], $message = 'Process success', $code = 200): JsonResponse
        {
            $response = [
                'success' => true,
                'data' => $data,
                'message' => $message,
            ];

            return response()->json($response, $code);
        }

        public static function error($data = [], $message = 'Process error, no changes', $code = 500): JsonResponse
        {
            Log::error($data);
            throw new HttpResponseException(response()->json([
                'code' => $code,
                'message' => $message
            ]));
        }

        public static function fail($e, $message = 'Process fail, rollback !', $code = 500): void
        {
            DB::rollBack();
            self::error([
                'exception' => $e->getMessage(),
                'message' => $message
            ], $code);
        }
    }
