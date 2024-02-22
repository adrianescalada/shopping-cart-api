<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\Product\Application\DeleteProductUseCase;
use Src\ShoppingContext\Product\Infrastructure\Repositories\EloquentProductRepository;

final class DeleteProductController
{
    private $repository;

    public function __construct(EloquentProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        $productId = (int)$request->id;

        $deleteProductUseCase = new DeleteProductUseCase($this->repository);
        $deleteProductUseCase->__invoke($productId);
    }
}
