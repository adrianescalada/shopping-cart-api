<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Resources\Order\Order as OrderResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\Order\Infrastructure\GetOrderController as GetOrderInfrastructure;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class GetOrderController extends Controller
{
    /**
     * @var GetOrderInfrastructure
     */
    private $getOrderController;

    public function __construct(GetOrderInfrastructure $getOrderController)
    {
        $this->getOrderController = $getOrderController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $getOrder = new OrderResource($this->getOrderController->__invoke($request));

        return response($getOrder, Response::HTTP_OK);
    }
}
