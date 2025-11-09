<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\GetChannel;

use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelMembershipRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;
use Alumni\Domain\Repository\DB\AttachmentsRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class GetChannelUseCase
{
    public function __construct(
        private readonly ChannelRepositoryInterface $channelRepository,
        private readonly ChannelMembershipRepositoryInterface $channelMembershipRepository,
        private readonly ChannelPostRepositoryInterface $channelPostRepository,
        private readonly AttachmentsRepositoryInterface $attachmentsRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(GetChannelRequest $requestDTO): GetChannelResponse
    {
        $channelData = $this->channelRepository->getById($requestDTO->channelId);
        $channelPosts = $this->channelPostRepository->getAllChannelPosts($requestDTO->channelId);
        $attachments = $this->attachmentsRepository->getUserAttachments($requestDTO->channelId);
        $user = $this->userRepository->getBy(['id' => $requestDTO->userId]);
        $members = $this->channelMembershipRepository->getMembersForChannel($requestDTO->channelId);

        return new GetChannelResponse(
            status: $channelData && $user ? 200 : 500,
            channel: $channelData,
            posts: $channelPosts,
            user: $user,
            attachments: $attachments,
            members: $members
        );

    }
}