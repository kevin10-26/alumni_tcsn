<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class Survey
{
    public function __construct(
        public int $id,
        public string $question,
        public array $options,
        public \DateTime $createdAt,
        public \DateTime $expiresAt
    ) {}
}
