<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class MasterProm
{
    public function __construct(
        public int $id,
        public int $year,
        public array $representatives = []
    ) {}
}
