<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\AuthenticateUser;

class AuthenticateUserRequest
{
    public function __construct(
        public readonly string $formerToken
    ) {}
}