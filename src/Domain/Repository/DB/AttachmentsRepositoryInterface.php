<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\Attachment;

interface AttachmentsRepositoryInterface
{
    public function getAll(): array;
    public function getBy(array $condition): Attachment;
    public function getChannelAttachments(int $channelId): array;
    public function getPostAttachments(int $postId, int $channelId): array;
    public function getUserAttachments(int $userId): array;
    public function removeFile(string $filePath, int $channelId): bool;
}