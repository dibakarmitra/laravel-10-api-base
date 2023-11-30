<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            if ($exception instanceof NotFoundHttpException || $exception instanceof MethodNotAllowedHttpException) {
                $statusCode = $exception->getStatusCode();
                $statusMessage = Response::$statusTexts[$statusCode];

                return response()->json([
                    'success' => false,
                    'statusCode' => $statusCode,
                    'statusMessage' => $statusMessage,
                    'errors' => [$exception->getMessage()],
                    'responseTime' => time(),
                ], $statusCode);
            }
            if ($exception instanceof ModelNotFoundException) {
                $statusCode = 404;
                $statusMessage = Response::$statusTexts[$statusCode];
                $model = $exception->getModel();
                preg_match('/[^\\\]*$/', $model, $modelName);

                return response()->json([
                    'success' => false,
                    'statusCode' => $statusCode,
                    'statusMessage' => $statusMessage,
                    'errors' => [($modelName[0] ?? 'Model') . ' not found.'],
                    'responseTime' => time(),
                ], $statusCode);
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
