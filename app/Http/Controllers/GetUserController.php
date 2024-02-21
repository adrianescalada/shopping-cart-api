<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Resources\UserResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\User\Infrastructure\GetUserController as GetUserInfrastructure;

class GetUserController extends Controller
{
    /**
     * @var GetUserInfrastructure
     */
    private $getUserController;

    public function __construct(GetUserInfrastructure $getUserController)
    {
        $this->getUserController = $getUserController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = new UserResource($this->getUserController->__invoke($request));

        return response($user, 200);
    }
}
