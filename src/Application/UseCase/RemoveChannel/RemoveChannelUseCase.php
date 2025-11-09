<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RemoveChannel;

use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;
use Alumni\Domain\Repository\File\ChannelFileRepositoryInterface;

use Alumni\Domain\Service\ChannelServiceInterface;

class RemoveChannelUseCase
{
    public function __construct(
        private readonly ChannelServiceInterface $channelService,
        private readonly ChannelFileRepositoryInterface $channelFileRepository,
        private readonly ChannelRepositoryInterface $channelRepository
    ) {}

    public function execute(RemoveChannelRequest $request): RemoveChannelResponse
    {
        // Check if provided user ID equals the one of the founder
        // And the founder's authenticity 
        if ($this->channelService->checkFounder($request->userId, $request->channelId, $request->userPassword))
        {
            $removeDBChannel = $this->channelRepository->remove($request->channelId);

            // Remove thumbnails and attachments
            $removeDirectoryChannel = $this->channelFileRepository->remove($request->channelId);

            return new RemoveChannelResponse(
                status: ($removeDBChannel && $removeDirectoryChannel) ? 200 : 500,
                channelHasBeenRemoved: ($removeDBChannel && $removeDirectoryChannel) ? true : false,
                msg: ($removeDBChannel && $removeDirectoryChannel) ? '' : 'Le channel n\'a pas pu être supprimé'
            );

        } else {
            return new RemoveChannelResponse(
                status: 400,
                channelHasBeenRemoved: false,
                msg: 'Votre identité n\'a pas pu être prouvée'
            );
        }
    }
}