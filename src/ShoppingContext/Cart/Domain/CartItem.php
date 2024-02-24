<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Domain;

use Src\ShoppingContext\Cart\Domain\ValueObjects\CartId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartItemProductId;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartItemQuantity;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartItemPrice;


final class CartItem
{
    private $cartId;
    private $productId;
    private $quantity;
    private $price;

    public function __construct(
        CartId $cartId,
        CartItemProductId $productId,
        CartItemQuantity $quantity,
        CartItemPrice $price,
    ) {
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function cartId(): CartId
    {
        return $this->cartId;
    }

    public function productId(): CartItemProductId
    {
        return $this->productId;
    }

    public function quantity(): CartItemQuantity
    {
        return $this->quantity;
    }

    public function price(): CartItemPrice
    {
        return $this->price;
    }

    public function calculateTotalPrice(): float
    {
        return $this->price()->value() * $this->quantity()->value();
    }
}
