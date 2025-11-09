<?php declare(strict_types=1);

namespace Alumni\Domain\Entity;

class Attachment
{
    public function __construct(
        public int $id,
        public string $filename,
        public string $originalName,
        public string $mimeType,
        public int $fileSize,
        public string $filePath,
        public \DateTime $uploadedAt,
        public ChannelPost $post
    ) {}
}
