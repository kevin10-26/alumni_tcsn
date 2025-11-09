<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UpdateChannelThumbnail;

use Psr\Http\Message\UploadedFileInterface;

class UpdateChannelThumbnailRequest
{
    public function __construct(
        public readonly int $userId,
        public readonly int $channelId,
        public readonly UploadedFileInterface $picture
    ) {}
}