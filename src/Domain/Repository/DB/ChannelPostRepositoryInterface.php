<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\DB;

use Alumni\Domain\Entity\ChannelPost;
use Alumni\Domain\Entity\File;

interface ChannelPostRepositoryInterface
{
    public function getAllPosts(): array;
    public function getAllChannelPosts(int $channelId): array;
    public function getPostsOfAuthor(int $userId): array;
    public function getPostBy(array $condition): ChannelPost;
    public function getPostWithAttachments(int $channelId): array;

    public function addToPool(File $file): bool;
    public function upload(
        int $userId,
        int $channelId,
        array $content,
        ?array $attachments
    ): bool;
    public function update(
        int $userId,
        int $channelId,
        int $postId,
        array $content,
        ?array $attachments
    ): bool;
    public function removeFromPool(array $documents): bool;
    public function removePost(int $postId): bool;
}