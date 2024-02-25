<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Resources\Product\Product as ProductResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\Product\Infrastructure\CreateProductController as CreateProductInfrastructure;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class CreateProductController extends Controller
{
    /**
     * @var CreateProductInfrastructure
     */
    private $createProductController;

    public function __construct(CreateProductInfrastructure $createProductController)
    {
        $this->createProductController = $createProductController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $newProduct = new ProductResource($this->createProductController->__invoke($request));
        return response($newProduct, Response::HTTP_CREATED);
    }
}
