<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdatePost;

use Alumni\Domain\Repository\DB\ChannelPostRepositoryInterface;
use Alumni\Domain\Repository\DB\AttachmentsRepositoryInterface;
use Alumni\Domain\Repository\File\PostChannelFileRepositoryInterface;
use Alumni\Domain\Service\FileServiceInterface;

class UpdatePostUseCase
{
    public function __construct(
        private readonly ChannelPostRepositoryInterface $channelPostRepository,
        private readonly PostChannelFileRepositoryInterface $postChannelFileRepository,
        private readonly AttachmentsRepositoryInterface $attachmentsRepository,
        private readonly FileServiceInterface $fileService
    ) {}

    public function execute(UpdatePostRequest $request): UpdatePostResponse
    {
        $documents = $this->fileService->getDocumentsDiff($request->content, $request->channelId, $request->postId);

        $clearPool = $this->channelPostRepository->removeFromPool($documents['newFiles']);
        $postUpload = $this->channelPostRepository->update($request->userId, $request->channelId, $request->postId, $request->content, $documents['newFiles']);
        $dbOk = $postUpload && $clearPool;

        $moveFiles = $this->postChannelFileRepository->moveFilesFromPool($documents['newFiles']['files'], $request->channelId, $this->postChannelFileRepository::POOL_FILE_TYPE);
        $movePictures = $this->postChannelFileRepository->moveFilesFromPool($documents['newFiles']['pictures'], $request->channelId, $this->postChannelFileRepository::POOL_PICTURE_TYPE);
        $fileOk = $moveFiles && $movePictures;

        if (count($documents['removedFilesFromPost']) > 0)
        {
            // dd('here', $documents);
            foreach($documents['removedFilesFromPost'] as $file)
            {
                $removeAttachmentFromDb = $this->attachmentsRepository->removeFile($file, $request->channelId);
                $removeAttachmentFromDirectory = $this->postChannelFileRepository->remove($request->channelId, $file);
                $removalOk = $removeAttachmentFromDb && $removeAttachmentFromDirectory;
            }
        }

        return new UpdatePostResponse(
            status: ($dbOk && $fileOk && (isset($removalOk) && $removalOk) || !isset($removalOk)) ? 200 : 500,
            msg: ($dbOk && $fileOk && (isset($removalOk) && $removalOk) || !isset($removalOk)) ? 'Votre publication a bien été modifiée' : 'Nous n\'avons pas pu modifier votre publication'
        );
    }
}