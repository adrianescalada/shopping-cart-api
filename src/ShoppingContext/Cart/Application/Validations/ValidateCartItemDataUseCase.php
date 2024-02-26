<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Application\Validations;

use Symfony\Component\HttpFoundation\Response;
use Src\ShoppingContext\Cart\Domain\Exceptions\CartItemsException;

class ValidateCartItemDataUseCase
{
    public function validate(array $data): void
    {

        foreach ($data as $productId => $item) {
            if (!is_array($item)) {
                throw new CartItemsException("Items", "array", "$productId");
            }

            if (!isset($item['quantity']) || !is_int($item['quantity']) || $item['quantity'] < 0) {
                throw new CartItemsException("Quantity", "Int",  "$productId");
            }

            if (!isset($item['price']) || !is_float($item['price']) || $item['price'] < 0) {
                throw new CartItemsException("Price", "float", "$productId");
            }
        }
    }
}
