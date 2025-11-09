<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\CreateReport;

class CreateReportResponse
{
    public function __construct(
        public readonly int $status
    ) {}
}