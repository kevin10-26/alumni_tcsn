<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\CreateReport;

class CreateReportRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $entityId,
        public readonly string $reportType,
        public readonly string $topic,
        public readonly ?string $description,

        /** @var <array|object> $attachments: is an array if there are multiple files. Otherwise, an object */
        public readonly mixed $attachments
    ) {}
}