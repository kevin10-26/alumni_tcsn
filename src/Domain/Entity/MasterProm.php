<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class MasterProm
{
    public function __construct(
        public int $id,
        public int $year,
        public string $name,
        public ?array $students = [],
        public ?array $delegates = []
    ) {}
}
