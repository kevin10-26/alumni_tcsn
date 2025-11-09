<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\File\Mapper;

use Alumni\Domain\Entity\File;

use Psr\Http\Message\UploadedFileInterface;

class FileMapper
{
    public function toDomain(UploadedFileInterface $file, ?string $fileUrl = '', ?string $poolName = ''): File
    {
        return new File(
            name: $file->getClientFilename(),
            tmpName: $file->getStream()->getMetadata('uri'),
            size: $file->getSize(),
            mimeType: $file->getClientMediaType(),
            errors: $file->getError(),
            url: $fileUrl ?? '',
            poolName: $poolName ?? ''
        );
    }
}