<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadPostPicture;

use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;
use Alumni\Domain\Repository\File\PostChannelFileRepositoryInterface;

use Alumni\Domain\Service\FileServiceInterface;

class UploadPostPictureUseCase
{
    public function __construct(
        private readonly ChannelPostRepositoryInterface $channelPostRepository,
        private readonly PostChannelFileRepositoryInterface $postChannelFileRepository,
        private readonly FileServiceInterface $fileService
    ) {}

    public function execute(UploadPostPictureRequest $requestDTO): UploadPostPictureResponse
    {
        $picture = $this->fileService->getFile($requestDTO->picture);
        $picture->poolName = hash('sha256', $picture->name);

        $uploadFile = $this->postChannelFileRepository->movePictureToPool($picture);
        $uploadDB = $this->channelPostRepository->addToPool($picture);

        $picture->url = $_ENV['APP_URL'] . 'img/channels/pool/' . $picture->poolName . '.' . pathinfo($picture->name, PATHINFO_EXTENSION);

        return new UploadPostPictureResponse(
            // According to Editor.js specs: 1 for success and 0 for error
            uploadStatus: $uploadDB ? 1 : 0,
            picture: $picture
        );
    }
}