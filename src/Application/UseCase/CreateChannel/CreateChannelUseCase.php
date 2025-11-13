<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\CreateChannel;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;

class CreateChannelUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly ChannelRepositoryInterface $channelRepository
    ) {}

    public function execute(CreateChannelRequest $request): CreateChannelResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);
        if (is_null($user) || !$user->hasBeenDelegate())
        {
            throw new \RuntimeException('Vous ne pouvez pas effectuer cette action', 400);
            exit;
        }

        $creation = $this->channelRepository->create($request->userId, $request->name, $request->description, $request->isPublic);

        return new CreateChannelResponse(
            status: $creation ? 200 : 500,
            channelId: $creation
        );
    }
}