<?php declare(strict_types=1);

namespace Alumni\Domain\Service;

interface ReportsServiceInterface
{
    public function getReportType(string $reportType, int $entityId): object;
}