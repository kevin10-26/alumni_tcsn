<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\AuthenticateUser;

class AuthenticateUserResponse
{
    public function __construct(
        public readonly array $token
    ) {}
}