<?php

declare(strict_types=1);

namespace Src\ShoppingContext\Product\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\Product\Application\GetProductUseCase;
use Src\ShoppingContext\Product\Application\UpdateProductUseCase;
use Src\ShoppingContext\Product\Infrastructure\Repositories\EloquentProductRepository;

final class UpdateProductController
{
    private $repository;

    public function __construct(EloquentProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        $productId = (int)$request->id;

        $getProductUseCase = new GetProductUseCase($this->repository);
        $product           = $getProductUseCase->__invoke($productId);

        $productCode              = $request->input('code') ?? $product->code()->value();
        $productName              = $request->input('name') ?? $product->name()->value();
        $productPrice             = $request->input('price') ?? $product->price()->value();
        $productQuantity          = $request->input('quantity') ?? $product->quantity()->value();
        $productDescription       = $request->input('description') ?? $product->description()->value();

        $updateProductUseCase = new UpdateProductUseCase($this->repository);
        $updateProductUseCase->__invoke(
            $productId,
            $productCode,
            $productName,
            $productPrice,
            $productQuantity,
            $productDescription
        );

        $updatedProduct = $getProductUseCase->__invoke($productId);

        return $updatedProduct;
    }
}
