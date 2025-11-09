<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetCompany;

class GetCompanyRequest
{
    public function __construct(
        public readonly string $input
    ) {}
}