<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class UserJobData
{
    public function __construct(
        public int $id,
        public string $company,
        public string $position,
        public \DateTime $startedAt,
        public ?\DateTime $stoppedAt = null
    ) {}
}
