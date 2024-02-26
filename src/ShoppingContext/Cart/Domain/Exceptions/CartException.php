<?php

namespace Src\ShoppingContext\Cart\Domain\Exceptions;

use App\Exceptions\ShoppingCartException;

class CartException extends ShoppingCartException
{
    public function __construct(string $message, $code)
    {
        parent::__construct(
            $message,
            $code,
        );
    }
}
