<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Application;

use Src\ShoppingContext\Product\Domain\Contracts\ProductRepositoryContract;
use Src\ShoppingContext\Product\Domain\Product;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductCode;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductName;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductPrice;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductQuantity;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductDescription;

final class CreateProductUseCase
{
    private $repository;

    public function __construct(ProductRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(
        string $productCode,
        string $productName,
        float $productPrice,
        int $quantity,
        ?string $description,
    ): void {
        $productCode       = new ProductCode($productCode);
        $productName       = new ProductName($productName);
        $productPrice      = new ProductPrice($productPrice);
        $quantity          = new ProductQuantity($quantity);
        $description       = new ProductDescription($description);
        $product = Product::create($productCode, $productName, $productPrice, $quantity, $description);
        $this->repository->save($product);
    }
}
