<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Cart\Application;

use Src\ShoppingContext\Cart\Domain\Contracts\CartRepositoryContract;
use Src\ShoppingContext\Cart\Domain\ValueObjects\CartId;

final class UpdateCartUseCase
{
    private $repository;

    public function __construct(CartRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(
        int $cartId,
        array $cartItems,
    ): CartId {
        $cartItems  = array($cartItems);
        $response = $this->repository->updateCart($cartId, $cartItems);
        return $response;
    }
}
