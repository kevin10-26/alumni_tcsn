<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetPortability;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\JobOfferRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelMembershipRepositoryInterface;
use Alumni\Domain\Repository\File\UserFileRepositoryInterface;

use Alumni\Domain\Service\MailingServiceInterface;

class GetPortabilityUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly JobOfferRepositoryInterface $jobOfferRepository,
        private readonly ChannelMembershipRepositoryInterface $channelMembershipRepository,
        private readonly UserFileRepositoryInterface $userFileRepository,
        private readonly MailingServiceInterface $mailingService
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
        $data = $this->userFileRepository->generatePortabilityFile($allData, $request->userId);

        $allFiles = $this->userFileRepository->getUserResources($request->userId, $attachments);

        $mailFlags = [
            'subject' => 'Votre fichier est prêt - Alumni TCSN',
            'attachments' => $this->mergeAllAttachments($allFiles)
        ];

        $this->mailingService->send('Votre fichier est prêt, il est en pièce jointe.', $allData['profile']->emailAddress->value(), $mailFlags);

        return new GetPortabilityResponse(
            status: $file ? 200 : 500,
            pathToPortabilityFile: $data['filePath']
        );
    }

    private function getPostsAttachments(array $channels): array
    {
        $attachments = [];
        foreach ($channels as $channel)
        {
            foreach ($channel['posts'] as $post)
            {
                $attachments[] = array_map(fn($attachment) => $_ENV['APP_DIR'] . $attachment->filePath, $post->attachments);
            }
        }
        return $attachments;
    }

    private function mergeAllAttachments(array $attachments): array {
        $result = [];
        array_walk_recursive($attachments, function($value) use (&$result) {
            $result[] = $value;
        });
        return $result;
    }
}