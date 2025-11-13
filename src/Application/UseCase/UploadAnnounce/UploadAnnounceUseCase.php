<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadAnnounce;

use Alumni\Domain\Repository\DB\AnnouncesRepositoryInterface;
use Alumni\Domain\Repository\DB\UserRepositoryInterface;

class UploadAnnounceUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AnnouncesRepositoryInterface $announceRepository
    ) {}

    public function execute(UploadAnnounceRequest $request): UploadAnnounceResponse
    {
        $user = $this->userRepository->getBy(['id' => $request->userId]);
        if (is_null($user) || !$user->hasBeenDelegate())
        {
            throw new \RuntimeException('Vous ne pouvez pas effectuer cette action', 400);
            exit;
        }

        $upload = $this->announceRepository->new($request->userId, $request->title, $request->content);

        return new UploadAnnounceResponse(
            status: $upload ? 200 : 500
        );
    }
}