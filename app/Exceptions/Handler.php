<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use League\OAuth2\Server\Exception\OAuthServerException;


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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof RequestException) {
            Log::error(JsonResponse::HTTP_INTERNAL_SERVER_ERROR . ' ' . $exception);
            return response()->json(['message' => "External API call failed", "code" => JsonResponse::HTTP_INTERNAL_SERVER_ERROR], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($exception instanceof AuthenticationException) {
            return response()->json(['message' => "Unauthenticated", "code" => JsonResponse::HTTP_UNAUTHORIZED], JsonResponse::HTTP_UNAUTHORIZED);
        }
        if ($exception instanceof ModelNotFoundException) {
            Log::debug(JsonResponse::HTTP_NOT_FOUND . ' ' . $exception);
            return response()->json(['message' => "Not found", "code" => JsonResponse::HTTP_NOT_FOUND], JsonResponse::HTTP_NOT_FOUND);
        }

        $code = $exception->getCode() ? $exception->getCode() : JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        //dd($exception);
        return response()->json(['message' => $exception->getMessage(), "code" => $code], $code);
    }
}
