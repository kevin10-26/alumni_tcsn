<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\SearchCompany;

class SearchCompanyResponse
{
    public function __construct(
        public readonly int $status,
        public readonly array $companies
    ) {}
}