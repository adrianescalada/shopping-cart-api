<?php

declare(strict_types=1);

namespace src\ShoppingContext\Product\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\Product\Application\CreateProductUseCase;
use Src\ShoppingContext\Product\Application\GetProductByCriteriaUseCase;
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

        $createProductUseCase->__invoke(
            $productCode,
            $productName,
            $productPrice,
            $productQuantity,
            $productDescription,
        );

        $getProductByCriteriaUseCase = new GetProductByCriteriaUseCase($this->repository);
        $newProduct                  = $getProductByCriteriaUseCase->__invoke($productCode, $productName);

        return $newProduct;
    }
}
