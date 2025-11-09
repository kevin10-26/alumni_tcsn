<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\CreateReport;

use Alumni\Domain\Repository\DB\ReportsRepositoryInterface;
use Alumni\Domain\Service\ReportsServiceInterface;

class CreateReportUseCase
{
    public function __construct(
        private readonly ReportsRepositoryInterface $reportRepository,
        private readonly ReportsServiceInterface $reportsService
    ) {}

    public function execute(CreateReportRequest $request): CreateReportResponse
    {
        $entity = $this->reportsService->getReportType($request->reportType, $request->entityId);
        $registerReport = $this->reportRepository->create(
            $request->userId,
            $request->entityId,
            $request->reportType,
            $entity,
            $request->topic,
            $request->description,
            $request->attachments
        );

        return new CreateReportResponse(
            ($registerReport) ? 200 : 500
        );
    }
}