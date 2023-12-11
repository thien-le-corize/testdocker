<?php

namespace App\Exceptions;

use Throwable;
use App\Exceptions\BaseException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response as HttpStatusCode;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

class Handler extends ExceptionHandler
{
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
        JWTException::class,
        TokenExpiredException::class,
        TokenBlacklistedException::class,
        ValidationException::class,
        AuthorizationException::class,
        AuthenticationException::class,
        NotFoundHttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $e)
    {
        /** @phpstan-ignore-next-line */
        return parent::report($e);
    }

    public function render($request, Throwable $exception)
    {
        $statusCode = HttpStatusCode::HTTP_BAD_REQUEST;
        $errors      = [];
        $message     = 'An error has occurred';
        $messageCode = '';

        switch (true) {
            case $exception instanceof ValidationException:
                $message = 'errors validation';
                $statusCode = HttpStatusCode::HTTP_UNPROCESSABLE_ENTITY;
                $messageCode = 422;
                $errors = $exception->errors();
                break;

            case $exception instanceof AuthenticationException:
                $message = 'Unauthenticated';
                $statusCode = HttpStatusCode::HTTP_UNAUTHORIZED;
                $messageCode = 'session.not_found';
                break;

            case $exception instanceof AuthorizationException:
                $message = 'Forbidden Access to this resource on the server is denied';
                $statusCode = HttpStatusCode::HTTP_FORBIDDEN;
                $messageCode = 'Forbidden';
                break;

            case $exception instanceof NotFoundHttpException:
                $message = 'Route Not Found';
                $statusCode = HttpStatusCode::HTTP_NOT_FOUND;
                $messageCode = 'route.not_found';
                break;


            case $exception instanceof ModelNotFoundException:
                $message = 'record not found';
                $statusCode = HttpStatusCode::HTTP_NOT_FOUND;
                $messageCode = 'record.not_found';
                break;

            case $exception instanceof MaintenanceModeException:
                $message = 'server has been maintain!';
                $statusCode = HttpStatusCode::HTTP_SERVICE_UNAVAILABLE;
                break;

            case $exception instanceof BaseException:
                $message = $exception->getMessage();
                $messageCode = method_exists($exception, 'getMessageCode') ? $exception->getMessageCode() : null;
                $statusCode = $exception->getCode();
                break;

            case $exception instanceof HttpException:
                $message = $exception->getMessage();
                break;

            default:
                break;
        }

        return $request->accepts(['application/json', '*/*'])
            ? response()->json([
                'message' => $message,
                'errors'  => $errors,
                'messageCode'  => $messageCode,
                ], $statusCode)
            : response($message, HttpStatusCode::HTTP_BAD_REQUEST);
    }
}
