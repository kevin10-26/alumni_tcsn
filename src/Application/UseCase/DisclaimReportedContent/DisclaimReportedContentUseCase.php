<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\DisclaimReportedContent;

use Alumni\Domain\Repository\DB\ReportsRepositoryInterface;

class DisclaimReportedContentUseCase
{
    public function __construct(
        private readonly ReportsRepositoryInterface $reportsRepository,
    ) {}

    public function execute(DisclaimReportedContentRequest $request): DisclaimReportedContentResponse
    {
        $reportUpdated = $this->reportsRepository->resolve($request->reportId, $request->decision, $request->reason);

        return new DisclaimReportedContentResponse(
            status: $reportUpdated ? 200 : 500,
            msg: $reportUpdated ? 'Le signalement a été mis à jour' : 'Le signalement n\'a pas pu être mis à jour'
        );
    }
}