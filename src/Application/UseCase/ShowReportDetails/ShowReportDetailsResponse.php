<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ShowReportDetails;

use Alumni\Domain\Entity\Report;

class ShowReportDetailsResponse
{
    public function __construct(
        public readonly int $status,
        public readonly Report $report
    ) {}
}