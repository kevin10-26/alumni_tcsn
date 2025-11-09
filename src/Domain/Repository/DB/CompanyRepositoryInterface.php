<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\Company;

interface CompanyRepositoryInterface
{
    public function getAll(): array;
    public function getBy(array $condition): Company;
    public function searchCompanies(string $name): array;
}