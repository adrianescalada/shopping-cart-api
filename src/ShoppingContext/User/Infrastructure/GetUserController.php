<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Infrastructure;

use Illuminate\Http\Request;
use Src\ShoppingContext\User\Application\GetUserUseCase;
use Src\ShoppingContext\User\Infrastructure\Repositories\EloquentUserRepository;

final class GetUserController
{
    private $repository;

    public function __construct(EloquentUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        $userId = (int)$request->id;

        $getUserUseCase = new GetUserUseCase($this->repository);
        $user           = $getUserUseCase->__invoke($userId);

        return $user;
    }
}
