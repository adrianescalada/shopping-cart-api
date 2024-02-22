<?php

namespace Src\ShoppingContext\Product\Infrastructure\Repositories\Exceptions;

use App\Exceptions\ShoppingCartException;
use Symfony\Component\HttpFoundation\Response;

class DuplicateCodeException extends ShoppingCartException
{
    public function __construct(string $code)
    {
        $message = "Duplicate code " . $code;

        parent::__construct(
            $message,
            Response::HTTP_CONFLICT,
        );
    }
}
