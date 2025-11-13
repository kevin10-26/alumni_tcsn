<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ShowReportDetails;

use Alumni\Domain\Repository\DB\ReportsRepositoryInterface;

class ShowReportDetailsUseCase
{
    public function __construct(
        private readonly ReportsRepositoryInterface $reportRepository
    ) {}

    public function execute(ShowReportDetailsRequest $request): ShowReportDetailsResponse
    {
        $report = $this->reportRepository->getBy(['id' => $request->reportId]);
        
        return new ShowReportDetailsResponse(
            status: $report ? 200 : 500,
            report: $report
        );
    }
}