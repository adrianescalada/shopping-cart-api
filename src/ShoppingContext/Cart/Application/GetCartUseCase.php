<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Application;

use Src\ShoppingContext\Cart\Domain\Contracts\CartRepositoryContract;
use Src\ShoppingContext\Cart\Domain\Cart;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartId;

final class GetCartUseCase
{
    private $repository;

    public function __construct(CartRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $cartId): ?Cart
    {
        $cartId  = new cartId($cartId);

        $cart = $this->repository->find($cartId);

        return $cart;
    }
}
