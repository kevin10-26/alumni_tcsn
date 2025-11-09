<?php

declare(strict_types=1);

namespace Alumni\Application\UseCase\Home;

use Alumni\Domain\Entity\User;

class HomeResponse
{
    public function __construct(
        public User $user,
        public array $events
    ) {}
}