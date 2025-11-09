<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class Event
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public \DateTime $createdAt,
        public \DateTime $updatedAt
    ) {}
}