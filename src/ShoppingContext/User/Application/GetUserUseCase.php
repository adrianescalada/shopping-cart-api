<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Application;

use Src\ShoppingContext\User\Domain\Contracts\UserRepositoryContract;
use Src\ShoppingContext\User\Domain\User;
use Src\ShoppingContext\User\Domain\ValueObjects\UserId;

final class GetUserUseCase
{
    private $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $userId): ?User
    {
        $id = new UserId($userId);

        $user = $this->repository->find($id);

        return $user;
    }
}
