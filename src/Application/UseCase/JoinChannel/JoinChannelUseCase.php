<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\JoinChannel;

use Alumni\Domain\Repository\DB\ChannelMembershipRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class JoinChannelUseCase
{
    public function __construct(
        private readonly ChannelMembershipRepositoryInterface $channelMembershipRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(JoinChannelRequest $requestDTO): JoinChannelResponse
    {
        $user = $this->userRepository->getBy(['id' => $requestDTO->userId]);

        if (is_null($user))
        {
            return new QuitChannelResponse(
                status: 401,
                msg: 'Provided user is unknown'
            );
        }

        $joinChannel = $this->channelMembershipRepository->addUserToChannel($user, $requestDTO->channelId);

        return new JoinChannelResponse(
            status: $joinChannel ? 200 : 500,
            channelId: $requestDTO->channelId
        );
    }
}