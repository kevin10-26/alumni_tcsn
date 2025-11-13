<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\EditAnnounce;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\DB\AnnouncesRepositoryInterface;

class EditAnnounceUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AnnouncesRepositoryInterface $announcesRepository
    ) {}

    public function execute(EditAnnounceRequest $request): EditAnnounceResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);
        if (is_null($user) || !$user->hasBeenDelegate())
        {
            throw new \RuntimeException('Vous ne pouvez pas effectuer cette action', 400);
            exit;
        }

        $edit = $this->announcesRepository->update($request->announceId, $request->title, $request->content);
        return new EditAnnounceResponse(
            status: $edit ? 200 : 500
        );
    }
}