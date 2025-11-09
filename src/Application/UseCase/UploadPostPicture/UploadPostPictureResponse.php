<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadPostPicture;

use Alumni\Domain\Entity\File;

class UploadPostPictureResponse
{
    public function __construct(
        public readonly int $uploadStatus,
        public readonly File $picture
    ) {}
}