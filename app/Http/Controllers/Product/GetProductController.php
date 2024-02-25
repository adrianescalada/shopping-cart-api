<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Resources\Product\Product as ProductResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\Product\Infrastructure\GetProductController as GetProductInfrastructure;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class GetProductController extends Controller
{
    /**
     * @var GetProductInfrastructure
     */
    private $getProductController;

    public function __construct(GetProductInfrastructure $getProductController)
    {
        $this->getProductController = $getProductController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $product = new ProductResource($this->getProductController->__invoke($request));

        return response($product, Response::HTTP_OK);
    }
}
