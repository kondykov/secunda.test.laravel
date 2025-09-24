<?php

use App\Utils\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $isApiRequest = function (Request $request = null): bool {
            if (!$request) {
                $request = request();
            }
            return $request->is('api/*') || $request->expectsJson();
        };

        $exceptions->render(function (ValidationException $e, Request $request) use ($isApiRequest) {
            if ($isApiRequest($request)) {
                return ApiResponse::error($e->errors(), status: 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) use ($isApiRequest) {
            if ($isApiRequest($request)) {
                return ApiResponse::error($e->getMessage(), status: 404);
            }

            return null;
        });

//        $exceptions->render(function (Exception $e, Request $request) use ($isApiRequest) {
//            if ($isApiRequest($request)) {
//                $isDebug = config('app.debug');
//
//                if ($isDebug) {
//                    return ApiResponse::error([
//                        'message' => $e->getMessage(),
//                        'code' => $e->getCode(),
//                        'file' => $e->getFile(),
//                        'line' => $e->getLine(),
//                        'trace' => $e->getTrace(),
//                    ], status: 500);
//                }
//
//                return ApiResponse::error('Internal Server Error', status: 500);
//            }
//
//            return null;
//        });
    })->create();
