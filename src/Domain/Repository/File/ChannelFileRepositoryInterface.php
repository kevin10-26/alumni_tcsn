<?php declare(strict_types=1);

namespace Alumni\Domain\Repository\File;

use Alumni\Domain\Entity\File;

interface ChannelFileRepositoryInterface
{
    public function uploadThumbnail(int $channelId, File $picture): string;
    public function remove(int $channelId): bool;
}