<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Resources\Order\Order as OrderResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\Order\Infrastructure\ConfirmPurchaseCartController;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ConfirmPurchaseController extends Controller
{
    /**
     * @var ConfirmPurchaseCartInfrastructure
     */
    private $confirmPurchaseCartController;

    public function __construct(ConfirmPurchaseCartController $confirmPurchaseCartController)
    {
        $this->confirmPurchaseCartController = $confirmPurchaseCartController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $confirmPurchaseCart = new OrderResource($this->confirmPurchaseCartController->__invoke($request));

        return response($confirmPurchaseCart, Response::HTTP_OK);
    }
}
