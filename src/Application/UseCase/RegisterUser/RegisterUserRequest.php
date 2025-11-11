<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RegisterUser;

class RegisterUserRequest
{
    public function __construct(
        public string $username,
        public string $emailAddress,
        public string $password
    ) {}
}