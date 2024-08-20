<?php

    namespace App\Http\Responses\API;

    use Illuminate\Contracts\Support\Responsable;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Log;
    use Symfony\Component\HttpFoundation\Response;

    readonly class ApiSuccessResponse implements Responsable
    {
        public function __construct(

            private mixed  $data,
            private string $message,
            private int    $code = Response::HTTP_OK,
            private bool   $success = true
        )
        {
        }

        public function toResponse($request): JsonResponse|Response
        {
            Log::notice($this->message, (array)$this->data);

            return response()->json(
                [
                    'success' => $this->success,
                    'message' => $this->message,
                    'additional' => $this->data->additional ?? [],
                    'data' => $this->data,
                ],
                $this->code
            );
        }
    }
