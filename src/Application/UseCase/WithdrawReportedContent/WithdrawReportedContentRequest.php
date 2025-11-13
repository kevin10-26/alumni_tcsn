<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\WithdrawReportedContent;

class WithdrawReportedContentRequest
{
    public function __construct(
        public readonly int $id,
        public readonly int $reportId,
        public readonly string $contentType,
        public readonly string $reason,
        public readonly string $decision
    ) {}
}