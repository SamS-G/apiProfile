<?php

    namespace App\Http\Exceptions;

    use Exception;
    use Illuminate\Http\JsonResponse;
    use Symfony\Component\HttpFoundation\Response as ResponseAlias;

    class RequestException extends Exception
    {
        protected $message;
        protected mixed $statusCode;

        public function __construct(
            $message = "Api request error",
            $statusCode = ResponseAlias::HTTP_BAD_REQUEST,
            $file = null,
            $line = null,
        )
        {
            parent::__construct($message);
            $this->message = $message;
            $this->statusCode = $statusCode;
            $this->file = $file;
            $this->line = $line;
        }

        public function toResponse(): JsonResponse
        {
            return response()->json([
                'error' => $this->message,
                'file' => $this->file,
                'line' => $this->line
            ], $this->statusCode);
        }
    }
