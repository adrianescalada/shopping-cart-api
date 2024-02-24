<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Resources\Cart\Cart as CartResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\Cart\Infrastructure\GetCartController as GetCartInfrastructure;
use App\Http\Controllers\Controller;

class GetCartController extends Controller
{
    /**
     * @var GetCartInfrastructure
     */
    private $getCartController;

    public function __construct(GetCartInfrastructure $getCartController)
    {
        $this->getCartController = $getCartController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $addCart = new CartResource($this->getCartController->__invoke($request));

        return response($addCart, 201);
    }
}
