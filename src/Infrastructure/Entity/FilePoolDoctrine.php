<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class FilePoolDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    private int $id;
    
    #[ORM\Column(type: 'string', length: 255)]
    private string $clientFilename;

    #[ORM\Column(type: 'string', length: 255)]
    private string $poolName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $mimeType;

    public function getId(): int
    {
        return $this->id;
    }

    public function getClientFilename(): string
    {
        return $this->clientFilename;
    }

    public function setClientFilename(string $clientFilename): self
    {
        $this->clientFilename = $clientFilename;
        return $this;
    }

    public function getPoolName(): string
    {
        return $this->poolName;
    }

    public function setPoolName(string $poolName): self
    {
        $this->poolName = $poolName;
        return $this;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;
        return $this;
    }
}