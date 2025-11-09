<?php

declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class RefreshToken
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    public string $token;

    #[ORM\Column(type: 'bigint')]
    public int $adminId;

    #[ORM\Column(type: 'datetime')]
    public \DateTime $expiresAt;

    #[ORM\Column(type: 'datetime')]
    public \DateTime $createdAt;

    public function __construct(
        string $token,
        int $adminId,
        \DateTime $expiresAt
    ) {
        $this->token = $token;
        $this->adminId = $adminId;
        $this->expiresAt = $expiresAt;
        $this->createdAt = new \DateTime();
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getUserId(): int
    {
        return $this->adminId;
    }

    public function getExpiresAt(): \DateTime
    {
        return $this->expiresAt;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function isExpired(): bool
    {
        return $this->expiresAt < new \DateTime();
    }
}
