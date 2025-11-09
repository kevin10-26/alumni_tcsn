<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\ListAllChannels;

use Alumni\Application\UseCase\ListAllChannels\ListAllChannelsRequest;
use Alumni\Application\UseCase\ListAllChannels\ListAllChannelsResponse;

use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelMembershipRepositoryInterface;

class ListAllChannelsUseCase
{
    public function __construct(
        private readonly ChannelRepositoryInterface $channelRepository,
        private readonly ChannelMembershipRepositoryInterface $channelMembershipRepository,
    ) {}

    public function execute(ListAllChannelsRequest $requestDTO): ListAllChannelsResponse
    {
        $channels = $this->channelRepository->getAll();
        $userChannels = $this->channelMembershipRepository->getChannelsForUser($requestDTO->userId);

        return new ListAllChannelsResponse(
            status: $channels && $userChannels ? 200 : 500,
            channels: $channels,
            userChannels: $userChannels
        );
    }
}