<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Application;

use DateTime;
use Src\ShoppingContext\User\Domain\Contracts\UserRepositoryContract;
use Src\ShoppingContext\User\Domain\User;
use Src\ShoppingContext\User\Domain\ValueObjects\UserEmail;
use Src\ShoppingContext\User\Domain\ValueObjects\UserEmailVerifiedDate;
use Src\ShoppingContext\User\Domain\ValueObjects\UserId;
use Src\ShoppingContext\User\Domain\ValueObjects\UserName;
use Src\ShoppingContext\User\Domain\ValueObjects\UserPassword;
use Src\ShoppingContext\User\Domain\ValueObjects\UserRememberToken;

final class UpdateUserUseCase
{
    private $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(
        int $userId,
        string $userName,
        string $userEmail,
        ?DateTime $userEmailVerifiedDate,
        string $userPassword,
        ?string $userRememberToken
    ): void {
        $id                = new UserId($userId);
        $name              = new UserName($userName);
        $email             = new UserEmail($userEmail);
        $emailVerifiedDate = new UserEmailVerifiedDate($userEmailVerifiedDate);
        $password          = new UserPassword($userPassword);
        $rememberToken     = new UserRememberToken($userRememberToken);

        $user = User::create($name, $email, $emailVerifiedDate, $password, $rememberToken);

        $this->repository->update($id, $user);
    }
}
