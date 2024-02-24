<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Domain;

use Src\ShoppingContext\Cart\Domain\ValueObjects\CartId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartUserId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartStatus;

final class Cart
{
    private CartId $cartId;
    private CartUserId $cartUserId;
    private CartStatus $cartStatus;
    public ?array $items;

    public function __construct(
        CartId $cartId,
        CartUserId $cartUserId,
        CartStatus $cartStatus,
        ?array $items,
    ) {
        $this->cartId = $cartId;
        $this->cartUserId = $cartUserId;
        $this->cartStatus = $cartStatus;
        $this->items = $items;
    }

    public function cartId(): CartId
    {
        return $this->cartId;
    }

    public function cartUserId(): CartUserId
    {
        return $this->cartUserId;
    }

    public function cartStatus(): CartStatus
    {
        return $this->cartStatus;
    }

    public function Items(): ?array
    {
        return $this->items;
    }

    public static function add(
        $cartId,
        $cartUserId,
        $cartStatus,
        array $cartItem,
    ): Cart {
        $cart = new self($cartId, $cartUserId, $cartStatus, $cartItem);

        return $cart;
    }
}
