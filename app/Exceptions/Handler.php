<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Mapeamento de exceções para respostas JSON.
     *
     * @var array
     */
    protected $exceptionMappings = [
        \Illuminate\Validation\ValidationException::class => [
            'message' => 'Validation error',
            'status' => 422,
        ],
        \Illuminate\Auth\AuthenticationException::class => [
            'message' => 'Unauthenticated',
            'status' => 401,
        ],
        \Illuminate\Auth\Access\AuthorizationException::class => [
            'message' => 'Unauthorized access',
            'status' => 403,
        ],
        \Illuminate\Database\Eloquent\ModelNotFoundException::class => [
            'message' => 'Item not found',
            'status' => 404,
        ],
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class => [
            'message' => 'Route not found',
            'status' => 404,
        ],
        \Illuminate\Database\QueryException::class => [
            'message' => 'Database error',
            'status' => 500,
        ],
    ];

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            foreach ($this->exceptionMappings as $exceptionClass => $mapping) {
                if ($exception instanceof $exceptionClass) {
                    return response()->json([
                        'message' => $mapping['message'],
                        'error' => $exception->getMessage() ?? null,
                    ], $mapping['status']);
                }
            }

            Log::error('Application error', [
                'message' => $exception->getMessage(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'trace'   => $exception->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Internal server error',
                'error' => $exception->getMessage() ?? null,
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
