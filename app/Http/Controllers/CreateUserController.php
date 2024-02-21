<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Resources\UserResource;
use Illuminate\Http\Request;
use Src\ShoppingContext\User\Infrastructure\CreateUserController as CreateUserInfrastructure;

class CreateUserController extends Controller
{
    /**
     * @var CreateUserInfrastructure
     */
    private $createUserController;

    public function __construct(CreateUserInfrastructure $createUserController)
    {
        $this->createUserController = $createUserController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $newUser = new UserResource($this->createUserController->__invoke($request));

        return response($newUser, 201);
    }
}
