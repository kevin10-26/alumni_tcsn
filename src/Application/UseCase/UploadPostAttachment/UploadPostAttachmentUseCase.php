<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadPostAttachment;

use Alumni\Domain\Repository\File\PostChannelFileRepositoryInterface;
use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;

use Alumni\Domain\Service\FileServiceInterface;

class UploadPostAttachmentUseCase
{
    public function __construct(
        private readonly PostChannelFileRepositoryInterface $postChannelFileRepository,
        private readonly ChannelPostRepositoryInterface $channelPostRepository,
        private readonly FileServiceInterface $fileService
    ) {}

    public function execute(UploadPostAttachmentRequest $requestDTO): UploadPostAttachmentResponse
    {
        $picture = $this->fileService->getFile($requestDTO->file);
        $picture->poolName = hash('sha256', $picture->name);

        $uploadFile = $this->postChannelFileRepository->moveFileToPool($picture);
        $uploadDB = $this->channelPostRepository->addToPool($picture);

        $picture->url = $_ENV['APP_URL'] . 'documents/channels/pool/' . $picture->poolName . '.' . pathinfo($picture->name, PATHINFO_EXTENSION);

        return new UploadPostAttachmentResponse(
            // According to Editor.js specs: 1 for success and 0 for error
            uploadStatus: $uploadDB ? 1 : 0,
            file: $picture
        );
    }
}