<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Resources\Product\Product as ProductResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\Product\Infrastructure\UpdateProductController as UpdateProductInfrastructure;
use App\Http\Controllers\Controller;

class UpdateProductController extends Controller
{
    /**
     * @var UpdateProductInfrastructure
     */
    private $updateProductController;

    public function __construct(UpdateProductInfrastructure $updateProductController)
    {
        $this->updateProductController = $updateProductController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $updatedProduct = new ProductResource($this->updateProductController->__invoke($request));

        return response($updatedProduct, 200);
    }
}