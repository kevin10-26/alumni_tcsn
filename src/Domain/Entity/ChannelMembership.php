<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class ChannelMembership
{
    public function __construct(
        public readonly int $id,
        public readonly User $user,
        public readonly Channel $channel,
        public readonly \DateTime $joinedAt,
        public readonly string $role
    ) {}
}