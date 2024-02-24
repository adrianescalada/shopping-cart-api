<?php

declare(strict_types=1);

namespace src\ShoppingContext\Product\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\Product\Application\CreateProductUseCase;
use Src\ShoppingContext\Product\Application\GetProductUseCase;
use Src\ShoppingContext\Product\Infrastructure\Repositories\EloquentProductRepository;

final class CreateProductController
{
    private $repository;

    public function __construct(EloquentProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        $productCode              = $request->input('code');
        $productName              = $request->input('name');
        $productPrice             = $request->input('price');
        $productQuantity          = $request->input('quantity');
        $productDescription       = $request->input('description');

        $createProductUseCase = new CreateProductUseCase($this->repository);

        $getProductUseCase = new GetProductUseCase($this->repository);

        $newProductId = $createProductUseCase->__invoke(
            $productCode,
            $productName,
            $productPrice,
            $productQuantity,
            $productDescription,
        );
        $newProduct = $getProductUseCase->__invoke($newProductId->value());
        return $newProduct;
    }
}
