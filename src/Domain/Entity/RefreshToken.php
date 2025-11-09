<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class RefreshToken
{
    public function __construct(
        public string $token,
        public int $adminId,
        public \DateTime $expiresAt,
        public \DateTime $createdAt
    ) {}
}
