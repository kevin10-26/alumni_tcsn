<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class StudentData
{
    public function __construct(
        public int $id,
        public MasterProm $prom,
        public bool $isDelegate,
        public string $userName,
        public int $userId,
        public ?array $flags = []
    ) {}
}
