<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Application;

use Src\ShoppingContext\Product\Domain\Contracts\ProductRepositoryContract;

final class GetAllProductUseCase
{
    private $repository;

    public function __construct(ProductRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(): array
    {
        $products = $this->repository->all();

        return $products;
    }
}
