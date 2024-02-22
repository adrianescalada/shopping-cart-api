<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Application;

use Src\ShoppingContext\Product\Domain\Contracts\ProductRepositoryContract;
use Src\ShoppingContext\Product\Domain\Product;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductId;

final class GetProductUseCase
{
    private $repository;

    public function __construct(ProductRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $productId): ?Product
    {
        $id = new ProductId($productId);

        $product = $this->repository->find($id);

        return $product;
    }
}
