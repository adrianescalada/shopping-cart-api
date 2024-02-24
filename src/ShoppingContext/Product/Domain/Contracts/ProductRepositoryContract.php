<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Domain\Contracts;

use Src\ShoppingContext\Product\Domain\Product;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductCode;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductId;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductName;

interface ProductRepositoryContract
{
    public function all(): array;

    public function find(ProductId $id): ?Product;

    public function findByCriteria(ProductCode $productCode, ProductName $ProductName): ?Product;

    public function save(Product $product): ProductId;

    public function update(ProductId $productId, Product $product): void;

    public function delete(ProductId $id): void;
}
