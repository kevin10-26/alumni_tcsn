<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadPostAttachment;

use Alumni\Domain\Entity\File;

class UploadPostAttachmentResponse
{
    public function __construct(
        public readonly int $uploadStatus,
        public readonly File $file
    ) {}
}