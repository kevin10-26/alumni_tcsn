<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class StudentData
{
    public function __construct(
        public int $id,
        public MasterProm $prom,
        public \DateTime $startedAt,
        public ?\DateTime $graduatedAt,
        public string $yearName,
        public bool $isDelegate
    ) {}
}
