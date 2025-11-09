<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadPostAttachment;

use Psr\Http\Message\UploadedFileInterface;

class UploadPostAttachmentRequest
{
    public function __construct(
        public readonly UploadedFileInterface $file
    ) {}
}