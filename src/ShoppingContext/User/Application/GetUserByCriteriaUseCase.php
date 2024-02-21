<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Application;

use Src\ShoppingContext\User\Domain\Contracts\UserRepositoryContract;
use Src\ShoppingContext\User\Domain\User;
use Src\ShoppingContext\User\Domain\ValueObjects\UserEmail;
use Src\ShoppingContext\User\Domain\ValueObjects\UserName;

final class GetUserByCriteriaUseCase
{
    private $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $userName, string $userEmail): ?User
    {
        $name  = new UserName($userName);
        $email = new UserEmail($userEmail);

        $user = $this->repository->findByCriteria($name, $email);

        return $user;
    }
}