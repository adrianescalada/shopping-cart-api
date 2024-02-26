<?php

declare(strict_types=1);

namespace src\ShoppingContext\Cart\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\Cart\Application\AddItemCartUseCase;
use Src\ShoppingContext\Cart\Application\GetCartUseCase;
use Src\ShoppingContext\Cart\Infrastructure\Repositories\EloquentCartRepository;
use Src\ShoppingContext\Cart\Application\Validations\ValidateCartItemDataUseCase;

final class AddItemCartController
{
    private $repository;

    private $validateCartItemDataUseCase;

    public function __construct(EloquentCartRepository $repository,  ValidateCartItemDataUseCase $ValidateCartItemDataUseCase)
    {
        $this->repository = $repository;
        $this->validateCartItemDataUseCase = $ValidateCartItemDataUseCase;
    }

    public function __invoke(Request $request)
    {
        $cartItems  = $request->input('products');

        $this->validateCartItemDataUseCase->validate($cartItems);

        $addItemCartUseCase = new AddItemCartUseCase($this->repository);

        $newCartId = $addItemCartUseCase->__invoke(
            $cartItems
        );

        $getCartUseCase = new GetCartUseCase($this->repository);

        $newCart = $getCartUseCase->__invoke($newCartId->value());

        return $newCart;
    }
}
