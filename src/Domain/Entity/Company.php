<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class Company
{
    public function __construct(
        public int $id,
        public string $companyName,
        public string $logo
    ) {}
}
