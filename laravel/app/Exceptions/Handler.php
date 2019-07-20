<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException as AuthException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Если ошибка связана с валидацией
        if ($exception instanceof ValidationException) {
            if ($request->ajax() || $request->wantsJson()) {
                $json = [
                    'status' => false,
                    'errors' => [],
                ];
                foreach ($exception->errors() as $key => $error) {
                    $json['errors'][] = [
                        'code' => 422,
                        'field' => $key,
                        'message' => 'VALIDATION_EXCEPTION',
                        'description' => $error[0],
                    ];
                }

                return response()->json($json, 200);
            }
        }

        // Если ошибка связана с недостатком прав
        if ($exception instanceof AuthorizationException || $exception instanceof AuthException) {
            if ($request->ajax() || $request->wantsJson()) {
                $json = [
                    'status' => false,
                    'errors' => [],
                ];
                $json['errors'][] = [
                    'code' => 403,
                    'message' => 'AUTHORIZATION_EXCEPTION',
                    'description' => $exception->getMessage(), //$request->language == "ru" ? 'Доступ запрещен. Возможно объект принадлежит другому пользователю.' : 'Permission denied. Maybe the object belongs to another user.',
                ];
                return response()->json($json, 200);
            }
        }

        // Если ошибка на сервере
        if ($exception instanceof FatalThrowableError) {
            if ($request->ajax() || $request->wantsJson()) {
                $json = [
                    'status' => false,
                    'errors' => [],
                ];
                $json['errors'][] = [
                    'code' => 500,
                    'message' => 'REAL_500', //,$exception->getMessage(),
                    'description' => $exception->getTrace(),
                ];
                return response()->json($json, 200);
            }
        }

        // Если ошибка в запросе
        if ($exception instanceof QueryException) {
            if ($request->ajax() || $request->wantsJson()) {
                $json = [
                    'status' => false,
                    'errors' => [],
                ];
                $json['errors'][] = [
                    'code' => 500,
                    'message' => 'QUERY_EXCEPTION',
                    'description' => $exception->getMessage(),
                    'trace' => $exception->getTrace(),
                ];
                return response()->json($json, 200);
            }
        }

        return parent::render($request, $exception);
    }
}
