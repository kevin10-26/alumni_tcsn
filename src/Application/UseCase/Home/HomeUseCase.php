<?php

declare(strict_types=1);

namespace Alumni\Application\UseCase\Home;

use Alumni\Application\UseCase\Home\HomeRequest;
use Alumni\Application\UseCase\Home\HomeResponse;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\EventRepositoryInterface;

class HomeUseCase
{
    public function __construct(
        public readonly UserRepositoryInterface $userRepository,
        public readonly EventRepositoryInterface $eventRepository
    ) {}

    public function execute(HomeRequest $request): HomeResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->adminId]);
        $events = $this->eventRepository->getLastEvents();

        return new HomeResponse(
            user: $user,
            events: $events
        );
    }
}