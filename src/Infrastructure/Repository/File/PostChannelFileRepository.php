<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\File;

use Alumni\Domain\Entity\File;

use Alumni\Domain\Repository\File\PostChannelFileRepositoryInterface;

class PostChannelFileRepository implements PostChannelFileRepositoryInterface
{
    public const POOL_PICTURE_TYPE = 'img/channels/';
    public const POOL_FILE_TYPE = 'documents/channels/';

    public function remove(int $channelId, string $filePath): bool
    {
        $mediaType = (preg_match('/\/img\//i', $filePath)) ? self::POOL_PICTURE_TYPE : self::POOL_FILE_TYPE;
        $filename = basename($filePath);

        $file = $_ENV['APP_DIR'] . "public/$mediaType/$channelId/$filename";
        if (file_exists($file))
        {
            unlink($file);
        }

        return true;
    }

    public function moveFileToPool(File $file): bool
    {
        return move_uploaded_file($file->tmpName, '/var/www/alumni_tcsn/public/documents/channels/pool/' . $file->poolName . '.' . pathinfo($file->name, PATHINFO_EXTENSION));
    }

    public function movePictureToPool(File $file): bool
    {
        return move_uploaded_file($file->tmpName, '/var/www/alumni_tcsn/public/img/channels/pool/' . $file->poolName . '.' . pathinfo($file->name, PATHINFO_EXTENSION));
    }

    public function moveFilesFromPool(
        array $files,
        int $channelId,
        string $poolType
    ): bool
    {
        foreach($files as $file)
        {
            $poolName = substr(strrchr($file['poolLocation'], '/'), 1);
            $poolPath = $_ENV['APP_DIR'] . 'public/' . $poolType . 'pool/' . $poolName;

            if (file_exists($poolPath))
            {
                rename(
                    $poolPath,
                    $_ENV['APP_DIR'] . "public/$poolType" . $channelId . '/' . substr(strrchr($file['url'], '/'), 1)
                );
            }
        }

        return true;
    }

    public function movePicturesFromPool(
        array $pictures,
        int $channelId
    ): bool
    {
        foreach($pictures as $file)
        {
            $poolName = substr(strrchr($file['poolLocation'], '/'), 1);
            $poolPath = $_ENV['public/img/channels/pool' . $poolName];

            if (file_exists($poolPath))
            {
                rename(
                    $poolPath,
                    $_ENV['APP_DIR'] . 'public/img/channels/' . $channelId . '/' . ($file['pool'] ?? $poolName)
                );
            }
        }

        return true;
    }
}