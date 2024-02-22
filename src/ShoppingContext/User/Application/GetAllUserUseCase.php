<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Application;

use Src\ShoppingContext\User\Domain\Contracts\UserRepositoryContract;
use Src\ShoppingContext\User\Domain\User;

final class GetAllUserUseCase
{
    private $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(): array
    {
        $users = $this->repository->all();

        return $users;
    }
}
