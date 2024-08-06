<?php

    use App\Http\Responses\API\ApiErrorResponse;
    use Illuminate\Foundation\Application;
    use Illuminate\Foundation\Configuration\Exceptions;
    use Illuminate\Foundation\Configuration\Middleware;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

    return Application::configure(basePath: dirname(__DIR__))
        ->withRouting(
            web: __DIR__ . '/../routes/web.php',
            api: __DIR__ . '/../routes/api.php',
            commands: __DIR__ . '/../routes/console.php',
            health: '/up',
        )
        ->withMiddleware(function (Middleware $middleware) {
            //
        })
        ->withExceptions(function (Exceptions $exceptions) {
            $exceptions->report(function (ArgumentCountError $e) {
               return new ApiErrorResponse('Arguments missing, check your request', $e);
            });
            $exceptions->report(function (Error $e) {
                return new ApiErrorResponse('Internal error, check your request', $e);
            });
            $exceptions->report(function (ErrorException $e) {
                return new ApiErrorResponse('Internal error, check your request', $e);
            });
            $exceptions->report(function (TypeError $e) {
                return new ApiErrorResponse('Internal error, check your request', $e);
            });
            $exceptions->report(function (NotFoundHttpException $e) {
                return new ApiErrorResponse('Route not found, please check your url or params', $e);
            });
        })
        ->create();
