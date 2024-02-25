<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Resources\Product\Products as ProductsResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\Product\Infrastructure\GetAllProductsController as GetAllProductsInfrastructure;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class GetAllProductsController extends Controller
{
    /**
     * @var GetAllUsersInfrastructure
     */
    private $getProductsController;

    public function __construct(GetAllProductsInfrastructure $getProductsController)
    {
        $this->getProductsController = $getProductsController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $Products = new ProductsResource($this->getProductsController->__invoke($request));
        return response($Products, Response::HTTP_OK);
    }
}
