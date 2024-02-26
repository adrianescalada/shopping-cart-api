<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Infrastructure\Common\Exceptions;

use Src\ShoppingContext\Cart\Domain\Exceptions\CartException;
use Symfony\Component\HttpFoundation\Response;

class ExceptionHandler
{
    public static function handle(\Exception $exception): void
    {
        $errorMessage = $exception->getMessage();
        $errorCode = $exception->getCode();

        if (strpos($errorMessage, 'Integrity constraint violation') !== false) {
            $errorMessage = "Integrity constraint violation";
            throw new CartException("$errorMessage", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        throw new CartException("$errorMessage", $errorCode);
    }
}
