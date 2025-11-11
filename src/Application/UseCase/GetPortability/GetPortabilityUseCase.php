<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetPortability;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\JobOfferRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelMembershipRepositoryInterface;
use Alumni\Domain\Repository\File\UserFileRepositoryInterface;

class GetPortabilityUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly JobOfferRepositoryInterface $jobOfferRepository,
        private readonly ChannelMembershipRepositoryInterface $channelMembershipRepository,
        private readonly UserFileRepositoryInterface $userFileRepository
    ) {}

    public function execute(GetPortabilityRequest $request): GetPortabilityResponse
    {
        $allData = array(
            'profile' => $this->userRepository->getBy(['id' => $request->userId]),
            'jobOffers' => array(
                'author' => $this->jobOfferRepository->getByAuthor($request->userId),
                'saved' => $this->jobOfferRepository->getUserSavedOffers($request->userId)
            ),
            'channels' => $this->channelMembershipRepository->getAllChannelsDataForUser($request->userId)
        );
        
        
        $attachments = $this->getPostsAttachments($allData['channels']);
        $file = $this->userFileRepository->generatePortabilityFile($allData, $request->userId);

        return new GetPortabilityResponse(
            status: $file ? 200 : 500,
            pathToPortabilityFile: $file
        );
    }

    private function getPostsAttachments(array $channels): array
    {
        $attachments = [];
        foreach ($channels as $channel)
        {
            foreach ($channel['posts'] as $post)
            {
                $attachments[] = array_column($post->attachments, 'filePath');
            }
        }
        return $attachments;
    }
}