<?php

    use App\Http\Responses\API\ApiResponse;
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
               ApiResponse::error('Arguments missing, check your request', 500);
            });
            $exceptions->report(function (Error $e) {
                ApiResponse::error('Internal error, check your request', 500, [$e->getMessage()]);
            });
            $exceptions->report(function (ErrorException $e) {
                ApiResponse::error('Internal error, check your request', 500, [$e->getMessage()]);
            });
            $exceptions->report(function (TypeError $e) {
                ApiResponse::error('Internal error, check your request', 500, [$e->getMessage()]);
            });
            $exceptions->report(function (NotFoundHttpException $e) {
                ApiResponse::error('Route not found, please check your url or params', 500, [$e->getMessage()]);
            });
        })
        ->create();
