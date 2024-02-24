<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Infrastructure\Repositories;

use App\Models\Product as EloquentProductModel;
use Src\ShoppingContext\Product\Domain\Contracts\ProductRepositoryContract;
use Src\ShoppingContext\Product\Domain\Product;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductCode;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductId;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductName;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductPrice;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductQuantity;
use Src\ShoppingContext\Product\Domain\ValueObjects\ProductDescription;
use Src\ShoppingContext\Product\Infrastructure\Repositories\Exceptions\DuplicateCodeException;
use Illuminate\Support\Facades\Redis;

final class EloquentProductRepository implements ProductRepositoryContract
{
    private $eloquentProductModel;

    public function __construct()
    {
        $this->eloquentProductModel = new EloquentProductModel;
    }

    public function all(): array
    {
        $products = Redis::get('products');

        if (!$products) {
            $products = $this->eloquentProductModel->get()->toArray();
            Redis::setex('products', 600, json_encode($products));
        } else {
            $products = json_decode($products, true);
        }

        return $products;
    }

    public function find(ProductId $id): ?Product
    {
        $product = $this->eloquentProductModel->findOrFail($id->value());
        // Return Domain Product model
        return new Product(
            new ProductId($product->id),
            new ProductCode($product->code),
            new ProductName($product->name),
            new ProductPrice($product->price),
            new ProductQuantity($product->quantity),
            new ProductDescription($product->description),
        );
    }

    public function findByCriteria(ProductCode $code, ProductName $name): ?Product
    {
        $product = $this->eloquentProductModel
            ->where('code', $code->value())
            ->where('name', $name->value())
            ->firstOrFail();

        // Return Domain Product model
        return new Product(
            new ProductId($product->id),
            new ProductCode($product->code),
            new ProductName($product->name),
            new ProductPrice($product->price),
            new ProductQuantity($product->quantity),
            new ProductDescription($product->description),
        );
    }

    public function save(Product $product): ProductId
    {
        $newProduct = $this->eloquentProductModel;

        $data = [
            'code'              => $product->code()->value(),
            'name'              => $product->name()->value(),
            'quantity'          => $product->quantity()->value(),
            'price'             => $product->price()->value(),
            'description'       => $product->description()->value(),
        ];

        $productExist = $newProduct
            ->where('code', $product->code()->value())
            ->first();

        if ($productExist) {
            throw new DuplicateCodeException($product->code()->value());
        }

        $productModel = $newProduct->create($data);
        $productId = new ProductId($productModel->id);

        return $productId;
    }

    /**
     * @param ProductId $id
     * @param Product $product
     * @return void
     */
    public function update(ProductId $id, Product $product): void
    {
        $productToUpdate = $this->eloquentProductModel;

        $data = [
            'code'          => $product->code()->value(),
            'name'          => $product->name()->value(),
            'quantity'      => $product->quantity()->value(),
            'price'         => $product->price()->value(),
            'description'   => $product->description()->value(),
        ];

        $productExist = $productToUpdate
            ->where('id', "<>", $id->value())
            ->where('code', $product->code()->value())
            ->first();

        if ($productExist) {
            throw new DuplicateCodeException($product->code()->value());
        }

        $productToUpdate
            ->findOrFail($id->value())
            ->update($data);
    }

    public function delete(ProductId $id): void
    {
        $this->eloquentProductModel
            ->findOrFail($id->value())
            ->delete();
    }
}
