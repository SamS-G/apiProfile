<?php

    namespace App\Http\Responses\API;

    use Illuminate\Contracts\Support\Responsable;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Log;
    use Symfony\Component\HttpFoundation\Response;
    use Throwable;

    readonly class ApiErrorResponse implements Responsable
    {
        public function __construct(
            private string     $message,
            private ?Throwable $exception = null,
            private int        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR,
            private array      $headers = [],
        )
        {
        }

        public function toResponse($request): JsonResponse|Response
        {
            $response = ['message' => $this->message];

            if (!is_null($this->exception) && config('app.debug')) {
                $response['debug'] = [
                    'message' => $this->exception->getMessage(),
                    'file' => $this->exception->getFile(),
                    'line' => $this->exception->getLine(),
                    'trace' => $this->exception->getTrace(),
                ];
            }
            Log::error($this->message, $response['debug'] ?? []);

            return response()->json($response, $this->statusCode, $this->headers);
        }
    }
