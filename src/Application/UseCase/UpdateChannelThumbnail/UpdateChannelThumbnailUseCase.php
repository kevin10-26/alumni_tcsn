<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateChannelThumbnail;

use Alumni\Domain\Repository\DB\ChannelRepositoryInterface;
use Alumni\Domain\Repository\File\ChannelFileRepositoryInterface;

use Alumni\Domain\Service\FileServiceInterface;

class UpdateChannelThumbnailUseCase
{
    public function __construct(
        private readonly ChannelRepositoryInterface $channelRepository,
        private readonly ChannelFileRepositoryInterface $channelFileRepository,
        private readonly FileServiceInterface $fileService
    ) {}

    public function execute(UpdateChannelThumbnailRequest $requestDTO): UpdateChannelThumbnailResponse
    {
        $picture = $this->fileService->getFile($requestDTO->picture);

        if ($this->fileService->isFileValid($picture, 'PICTURE'))
        {
            $updateDB = $this->channelRepository->update($requestDTO->channelId, ['thumbnail' => $picture->name]);
            $updateFile = $this->channelFileRepository->uploadThumbnail($requestDTO->channelId, $picture);

        } else 
        {
            return new UpdateChannelThumbnailResponse(
                status: 400,
                msg: 'Veuillez fournir une image valide.'
            );
        }

        return new UpdateChannelThumbnailResponse(
            status: ($updateDB && $updateFile) ? 200 : 500,
            msg: ($updateDB && $updateFile) ? 'La miniature du channel a été mise à jour' : 'Erreur lors de la mise à jour de la miniature du channel',
            thumbnailPath: $updateFile
        );
    }
}