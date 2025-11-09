<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadPost;

use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;
use Alumni\Domain\Repository\File\PostChannelFileRepositoryInterface;
use Alumni\Domain\Service\FileServiceInterface;

class UploadPostUseCase
{
    public function __construct(
        private readonly ChannelPostRepositoryInterface $channelPostRepository,
        private readonly PostChannelFileRepositoryInterface $postChannelFileRepository,
        private readonly FileServiceInterface $fileService
    ) {}

    public function execute(UploadPostRequest $request): UploadPostResponse
    {
        $documents = $this->fileService->getDocumentsFromChannelPost($request->content, $request->channelId);

        $clearPool = $this->channelPostRepository->removeFromPool($documents);
        $postUpload = $this->channelPostRepository->upload($request->userId, $request->channelId, $request->content, $documents);
        $dbOk = $postUpload && $clearPool;

        $moveFiles = $this->postChannelFileRepository->moveFilesFromPool($documents['files'], $request->channelId, $this->postChannelFileRepository::POOL_FILE_TYPE);
        $movePictures = $this->postChannelFileRepository->moveFilesFromPool($documents['pictures'], $request->channelId, $this->postChannelFileRepository::POOL_PICTURE_TYPE);
        $fileOk = $moveFiles && $movePictures;

        return new UploadPostResponse(
            status: ($dbOk && $fileOk) ? 200 : 500,
            msg: ($dbOk && $fileOk) ? 'Votre publication a bien été mise en ligne' : 'Nous n\'avons pas pu mettre en ligne votre publication'
        );
    }
}