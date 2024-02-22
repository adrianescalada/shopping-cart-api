<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Application;

use Src\ShoppingContext\Product\Domain\Contracts\ProductRepositoryContract;
use Src\ShoppingContext\Product\Domain\Product;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductCode;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductName;

final class GetProductByCriteriaUseCase
{
    private $repository;

    public function __construct(ProductRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $productCode, string $productName): ?Product
    {
        $code  = new ProductCode($productCode);
        $name  = new ProductName($productName);

        $product = $this->repository->findByCriteria($code, $name);

        return $product;
    }
}
