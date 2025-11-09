<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\File;

use Alumni\Domain\Entity\File;
use Alumni\Domain\Repository\File\ChannelFileRepositoryInterface;

use Alumni\Infrastructure\Repository\File\Mapper\FileMapper;

use Psr\Http\Message\UploadedFileInterface;

use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;

class ChannelFileRepository implements ChannelFileRepositoryInterface
{
    private const PATH_TO_ASSETS = '/var/www/alumni_tcsn/public/';

    public function uploadThumbnail(int $channelId, File $picture): string
    {
        $path = 'img/channels/' . $channelId . '/thumbnails/';
        $fullPath = self::PATH_TO_ASSETS . $path;

        if (!is_dir($fullPath))
        {
            mkdir($fullPath, 0755, true);
        }

        return $this->moveToDirectory($path, $picture) ? $path . $picture->name : '';
    }

    public function remove(int $channelId): bool
    {
        return (
            $this->removeDirectory(self::PATH_TO_ASSETS . 'img/channels/' . $channelId) &&
            $this->removeDirectory(self::PATH_TO_ASSETS . 'documents/channels/' . $channelId)
        );
    }

    private function moveToDirectory(string $path, object $file): bool
    {
        return move_uploaded_file($file->tmpName, '/var/www/alumni_tcsn/public/' . $path . $file->name);
    }

    private function removeDirectory(string $directory): bool
    {
        if (!is_dir($directory)) return true;

        $it = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
                     RecursiveIteratorIterator::CHILD_FIRST);

        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
        return rmdir($directory);
    }
}