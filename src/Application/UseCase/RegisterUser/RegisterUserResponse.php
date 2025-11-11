<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RegisterUser;

class RegisterUserResponse
{
    public function __construct(
        public int $status,
        public string $msg
    ) {}
}