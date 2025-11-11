<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

use Alumni\Domain\ValueObject\EmailAddress;

class UserRegistrationPool
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly EmailAddress $emailAddress,
        public readonly string $password
    ) {}
}