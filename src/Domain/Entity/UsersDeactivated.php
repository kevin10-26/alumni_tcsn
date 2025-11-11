<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class UsersDeactivated
{
    public function __construct(
        public readonly int $id,
        public readonly int $userId,
        public readonly \DateTime $startedAt,
        public readonly \DateTime $endsAt,
        public readonly string $origin
    ) {}
}