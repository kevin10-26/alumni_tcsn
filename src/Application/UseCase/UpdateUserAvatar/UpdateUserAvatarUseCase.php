<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateUserAvatar;

use Alumni\Domain\Service\UserServiceInterface;
use Alumni\Domain\Service\FileServiceInterface;

use Alumni\Domain\Repository\DB\UserRepositoryInterface;
use Alumni\Domain\Repository\File\UserFileRepositoryInterface;

class UpdateUserAvatarUseCase
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly FileServiceInterface $fileService,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserFileRepositoryInterface $userFileRepository
    ) {}

    public function execute(UpdateUserAvatarRequest $request): UpdateUserAvatarResponse
    {
        $avatar = $this->userService->getAvatar($request->avatar);
        $updateDb = $this->userRepository->update($request->userId, 'user-avatar', $avatar->name);

        $updateFile = false;
        if ($this->fileService->isFileValid($avatar, 'picture'))
        {
            $updateFile = $this->userFileRepository->moveAvatar($request->userId, $avatar);
        }

        return new UpdateUserAvatarResponse(
            status: $updateDb && $updateFile ? 200 : 500,
            msg: $updateDb && $updateFile ? "Votre photo de profil a été modifiée" : "Votre photo de profil n'a pas pu être modifiée",
            updatedAvatarPath: $updateFile
        );
    }
}