<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\Report;

interface ReportsRepositoryInterface
{
    public function getAll(): array;
    public function getMultipleBy(array $condition): array;
    public function getBy(array $condition): Report;
    
    public function create(
        int $userId,
        int $entityId,
        string $reportType,
        object $entity,
        string $reportTopic,
        string $reportDescription,
        ?array $attachments
    ): bool;

    public function resolve(int $reportId, string $decision, string $reason): bool;
}