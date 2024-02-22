<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\Product\Application\GetAllProductUseCase;
use Src\ShoppingContext\Product\Infrastructure\Repositories\EloquentProductRepository;

final class GetAllProductsController
{
    private $repository;

    public function __construct(EloquentProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        $getAllProductUseCase = new GetAllProductUseCase($this->repository);
        $products = $getAllProductUseCase->__invoke();

        return $products;
    }
}
