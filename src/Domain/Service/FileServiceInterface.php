<?php declare(strict_types=1);

namespace Alumni\Domain\Service;

use Alumni\Domain\Entity\File;

interface FileServiceInterface
{
    public function getFile(object $picture): File;
    public function isFileValid(File $file, string $mode): bool;
    public function getDocumentsFromChannelPost(array &$content, int $channelId): array;
    public function getDocumentsDiff(array &$content, int $channelId, int $postId): array;
}