<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Resources\User\Users as UsersResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\User\Infrastructure\GetAllUsersController as GetAllUsersInfrastructure;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class GetAllUsersController extends Controller
{
    /**
     * @var GetAllUsersInfrastructure
     */
    private $getUsersController;

    public function __construct(GetAllUsersInfrastructure $getUsersController)
    {
        $this->getUsersController = $getUsersController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $users = new UsersResource($this->getUsersController->__invoke($request));
        return response($users, Response::HTTP_OK);
    }
}
