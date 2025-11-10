<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\QuitChannel;

use Alumni\Domain\Repository\DB\ChannelMembershipRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class QuitChannelUseCase
{
    public function __construct(
        private readonly ChannelMembershipRepositoryInterface $channelMembershipRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(QuitChannelRequest $requestDTO): QuitChannelResponse
    {
        $user = $this->userRepository->getBy(['id' => $requestDTO->userId]);

        if (is_null($user))
        {
            return new QuitChannelResponse(
                status: 401,
                msg: 'Provided user is unknown'
            );
        }

        $quitChannel = $this->channelMembershipRepository->removeUserFromChannel($user, $requestDTO->channelId);

        return new QuitChannelResponse(
            status: $quitChannel ? 200 : 500,
            msg: $quitChannel ? 'User successfully quitted channel ' : 'Failed to remove user from channel '
        );
    }
}