<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Repository\File;

use Alumni\Domain\Entity\File;
use Alumni\Domain\Repository\File\UserFileRepositoryInterface;

class UserFileRepository implements UserFileRepositoryInterface
{
    public function moveAvatar(int $userId, File $avatar): string
    {
        $relativePath = "img/users/$userId/profile_pictures/$avatar->name";

        move_uploaded_file($avatar->tmpName, $_ENV['APP_DIR'] . 'public/' . $relativePath);

        return $relativePath;
    }

    public function getUserResources(int $userId, array $postAttachments): array
    {        
        return [
            'documents' => $this->rScanDir($_ENV['APP_DIR'] . "public/documents/users/$userId"),
            'channelDocuments' => $postAttachments,
            'images' => $this->rScanDir($_ENV['APP_DIR'] . "public/img/users/$userId")
        ];
    }

    public function generatePortabilityFile(array $userData, int $userId): array
    {
        $data = json_encode($userData, JSON_PRETTY_PRINT);

        $filePath = "documents/users/$userId/" . $userData['profile']->username . '_data.json';

        $stream = fopen($_ENV['APP_DIR'] . "public/$filePath", 'w');
        fwrite($stream, $data);
        fclose($stream);

        return array(
            'content' => $data,
            'filePath' => $filePath
        );
    }

    private function rScanDir(string $dir): array
    {
        $cdir = scandir($dir);
        $result = [];
        $relativePath = str_replace($_ENV['APP_DIR'], '', $dir);

        foreach ($cdir as $key => $value)
        {
            if (!in_array($value,array(".","..")))
            {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                {
                    $result[$value] = $this->rScanDir($dir . DIRECTORY_SEPARATOR . $value);
                }
                else
                {
                    $result[] = $_ENV['APP_DIR'] . $relativePath . DIRECTORY_SEPARATOR . $value;
                } 
            }
        }
        return $result;
    }
}