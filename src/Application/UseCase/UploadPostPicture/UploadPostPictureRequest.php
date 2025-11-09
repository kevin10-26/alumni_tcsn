<?php declare(strict_types=1);

namespace Alumni\Application\UseCase\UploadPostPicture;

use Psr\Http\Message\UploadedFileInterface;

class UploadPostPictureRequest
{
    public function __construct(
        public readonly UploadedFileInterface $picture
    ) {}
}