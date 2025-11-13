<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\RemoveAnnounce;

use Alumni\Domain\Repository\DB\AnnouncesRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class RemoveAnnounceUseCase
{
    public function __construct(
        private readonly AnnouncesRepositoryInterface $announcesRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function execute(RemoveAnnounceRequest $request): RemoveAnnounceResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);
        if (is_null($user) || !$user->hasBeenDelegate())
        {
            throw new \RuntimeException('Vous ne pouvez pas effectuer cette action', 400);
            exit;
        }

        $deletion = $this->announcesRepository->remove($request->announceId);

        return new RemoveAnnounceResponse(
            status: $deletion ? 200 : 500,
            msg: $deletion ? 'L\'annonce a bien été supprimée.' : 'L\'annonce n\'a pas pu être supprimée.'
        );
    }
}