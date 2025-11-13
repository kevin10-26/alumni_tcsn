<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\WithdrawReportedContent;

use Alumni\Domain\Repository\DB\ReportsRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;
use Alumni\Domain\Repository\DB\AnnouncesRepositoryInterface;
use Alumni\Domain\Repository\DB\JobOfferRepositoryInterface;

class WithdrawReportedContentUseCase
{
    public function __construct(
        private readonly ReportsRepositoryInterface $reportsRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly ChannelRepositoryInterface $channelRepository,
        private readonly ChannelPostRepositoryInterface $channelPostRepository,
        private readonly AnnouncesRepositoryInterface $announceRepository,
        private readonly JobOfferRepositoryInterface $jobOfferRepository,
    ) {}

    public function execute(WithdrawReportedContentRequest $request): WithdrawReportedContentResponse
    {
        $contentRemoval = $this->routeContentRemoval($request->contentType, $request->reportId);
        $reportUpdated = $this->reportsRepository->resolve($request->reportId, $request->decision, $request->reason);

        return new WithdrawReportedContentResponse(
            status: $reportUpdated && $contentRemoval ? 200 : 500,
            msg: $reportUpdated && $contentRemoval ? 'Le contenu a été retiré' : 'Le contenu n\'a pas pu être retiré'
        );
    }

    private function routeContentRemoval(string $contentType, int $reportId): bool
    {
        $report = $this->reportsRepository->getBy(['id' => $reportId]);
        if (is_null($report) || is_null($report->target)) return false;

        switch ($contentType)
        {
            case 'user':
                return $this->userRepository->remove($report->target->id);
                break;

            case 'post':
                return $this->channelPostRepository->removePost($report->target->id);
                break;

            case 'channel':
                return $this->channelRepository->remove($report->target->id);
                break;

            case 'announce':
                return $this->announceRepository->remove($report->target->id);
                break;

            case 'jobOffer':
                return $this->jobOfferRepository->remove($report->target->id);
                break;
        }
    }
}