<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RefreshBackofficeTab;


use Alumni\Domain\Repository\DB\ReportsRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;
use Alumni\Domain\Repository\DB\AnnouncesRepositoryInterface;
use Alumni\Domain\Repository\DB\JobOfferRepositoryInterface;

class RefreshBackofficeTabUseCase
{
    public function __construct(
        private readonly ReportsRepositoryInterface $reportsRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly AnnouncesRepositoryInterface $announcesRepository,
        private readonly ChannelRepositoryInterface $channelRepository,
        private readonly JobOfferRepositoryInterface $jobOfferRepository
    ) {}

    public function execute(RefreshBackofficeTabRequest $request): RefreshBackofficeTabResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);
        if (is_null($user) || !$user->hasBeenDelegate())
        {
            throw new \RuntimeException('Vous ne pouvez pas accéder à ce contenu', 400);
            exit;
        }

        $result = $this->resolveContentRefresh($request->tabName);

        return new RefreshBackofficeTabResponse(
            status: $result ? 200 : 500,
            content: $result['content'],
            templateName: $result['templateName']
        );
    }

    private function resolveContentRefresh(string $contentType): array
    {
        $content = [];
        $templateName = '';

        switch ($contentType)
        {
            case 'user':
                $content = $this->userRepository->getAll();
                $templateName = 'UsersList';
                break;

            case 'reports':
                $content = $this->reportsRepository->getAll();
                $templateName = 'ReportsList';
                break;

            case 'post':
                $content = $this->channelPostRepository->getAll();
                $templateName = 'PostsList';
                break;

            case 'channel':
                $content = $this->channelRepository->getAll();
                $templateName = 'ChannelsList';
                break;

            case 'announce':
                $content = $this->announceRepository->getAll();
                $templateName = 'AnnouncesList';
                break;

            case 'jobOffer':
                $content = $this->jobOfferRepository->getAll();
                $templateName = 'JobOffersList';
                break;

            default:
                throw new \RuntimeException('Vous ne pouvez pas accéder à ce contenu', 400);
                break;
        }

        return [
            'content' => $content,
            'templateName' => $templateName
        ];
    }
}