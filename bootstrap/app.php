<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\OnlyAdminMiddleware;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(OnlyAdminMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (HttpException $e, $request) {
            return response()->view('components.errors.index', [
                'statusCode' => $e->getStatusCode(),
                'message' => $e->getMessage(),
            ]);
        });

        $exceptions->render(function(Exception $e, $request)  {
            return response()->view('components.errors.index', [
                'statusCode' => $e->getCode() === 0 ? 500 : $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        });
    })->create();
