<?php

declare(strict_types=1);

namespace Alumni\Domain\Entity;

use Alumni\Domain\ValueObject\Avatar;

class UserData
{
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName,
        public Avatar $avatar,
        public ?string $address = null,
    ) {}
}
