<?php

declare(strict_types=1);

namespace Src\ShoppingContext\User\Domain;

use Src\ShoppingContext\User\Domain\ValueObjects\UserEmail;
use Src\ShoppingContext\User\Domain\ValueObjects\UserEmailVerifiedDate;
use Src\ShoppingContext\User\Domain\ValueObjects\UserName;
use Src\ShoppingContext\User\Domain\ValueObjects\UserPassword;
use Src\ShoppingContext\User\Domain\ValueObjects\UserRememberToken;

final class User
{
    private $name;
    private $email;
    private $emailVerifiedDate;
    private $password;
    private $rememberToken;

    public function __construct(
        UserName $name,
        UserEmail $email,
        UserEmailVerifiedDate $emailVerifiedDate,
        UserPassword $password,
        UserRememberToken $rememberToken
    )
    {
        $this->name              = $name;
        $this->email             = $email;
        $this->emailVerifiedDate = $emailVerifiedDate;
        $this->password          = $password;
        $this->rememberToken     = $rememberToken;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function emailVerifiedDate(): UserEmailVerifiedDate
    {
        return $this->emailVerifiedDate;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function rememberToken(): UserRememberToken
    {
        return $this->rememberToken;
    }

    public static function create(
        UserName $name,
        UserEmail $email,
        UserEmailVerifiedDate $emailVerifiedDate,
        UserPassword $password,
        UserRememberToken $rememberToken
    ): User
    {
        $user = new self($name, $email, $emailVerifiedDate, $password, $rememberToken);

        return $user;
    }
}