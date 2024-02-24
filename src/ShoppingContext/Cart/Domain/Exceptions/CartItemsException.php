<?php

namespace Src\ShoppingContext\Cart\Domain\Exceptions;

use App\Exceptions\ShoppingCartException;
use Symfony\Component\HttpFoundation\Response;

class CartItemsException extends ShoppingCartException
{
    public function __construct(string $item, string $type, string $productId)
    {
        $message = "Invalid " . $item . " format type: " . $type . " for product ID: " . $productId;

        parent::__construct(
            $message,
            Response::HTTP_UNPROCESSABLE_ENTITY,
        );
    }
}
