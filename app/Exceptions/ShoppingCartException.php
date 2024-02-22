<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Exception;
use Illuminate\Http\JsonResponse;

class ShoppingCartException extends Exception
{

    public function __construct(string $message, int $code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct(
            $message,
            $code
        );
        $this->render($message, $code);
    }

    public function render(string $message, int $code): JsonResponse
    {
        return response()->json(['message' => $message], $code);
    }
}