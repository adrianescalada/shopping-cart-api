<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Resources\Product\Product as ProductResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\Cart\Infrastructure\AddItemCartController as AddItemCartInfrastructure;
use App\Http\Controllers\Controller;

class DeleteItemCartController extends Controller
{
    /**
     * @var AddItemCartInfrastructure
     */
    private $addItemCartController;

    public function __construct(AddItemCartInfrastructure $addItemCartController)
    {
        $this->addItemCartController = $addItemCartController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $addProduct = new ProductResource($this->addItemCartController->__invoke($request));

        return response($addProduct, 201);
    }
}
