<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\File;

use Alumni\Domain\Entity\File;

interface PostChannelFileRepositoryInterface
{
    public function remove(int $channelId, string $filePath): bool;
    public function moveFileToPool(File $file): bool;
    public function movePictureToPool(File $file): bool;
    public function moveFilesFromPool(
        array $files,
        int $channelId,
        string $poolType
    ): bool;
}