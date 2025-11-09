<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetCompany;

use Alumni\Domain\Entity\Company;

class GetCompanyResponse
{
    public function __construct(
        public readonly int $status,
        public readonly Company $company
    ) {}
}