<?php

declare(strict_types=1);

namespace src\ShoppingContext\Cart\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\Cart\Application\UpdateCartUseCase;
use Src\ShoppingContext\Cart\Application\GetCartUseCase;
use Src\ShoppingContext\Cart\Infrastructure\Repositories\EloquentCartRepository;

final class UpdateCartController
{
    private $repository;

    public function __construct(EloquentCartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        $cartId = (int)$request->id;
        $cartItems  = $request->input('items');

        $updateCartUseCase = new UpdateCartUseCase($this->repository);

        $newCartId = $updateCartUseCase->__invoke(
            $cartId,
            $cartItems
        );

        $getCartUseCase = new GetCartUseCase($this->repository);

        $newCart = $getCartUseCase->__invoke($newCartId->value());

        return $newCart;
    }
}
