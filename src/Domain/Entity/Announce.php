<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class Announce
{
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public User $author,
        public \DateTime $publishedAt,
        public ?\DateTime $updatedAt
    ) {}
}