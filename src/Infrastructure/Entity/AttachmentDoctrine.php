<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

use Alumni\Infrastructure\Entity\ChannelPostDoctrine;

#[ORM\Entity]
class AttachmentDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    public int $id;

    #[ORM\Column(type: 'string', length: 255)]
    public string $filename;

    #[ORM\Column(type: 'string', length: 255)]
    public string $originalName;

    #[ORM\Column(type: 'string', length: 100)]
    public string $mimeType;

    #[ORM\Column(type: 'bigint')]
    public int $fileSize;

    #[ORM\Column(type: 'string', length: 500)]
    public string $filePath;

    #[ORM\Column(type: 'datetime')]
    public \DateTime $uploadedAt;

    #[ORM\ManyToOne(targetEntity: ChannelPostDoctrine::class, inversedBy: 'attachments')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    public ?ChannelPostDoctrine $post = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): self
    {
        $this->originalName = $originalName;
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

    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    public function setFileSize(int $fileSize): self
    {
        $this->fileSize = $fileSize;
        return $this;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): self
    {
        $this->filePath = $filePath;
        return $this;
    }

    public function getUploadedAt(): \DateTime
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt(\DateTime $uploadedAt): self
    {
        $this->uploadedAt = $uploadedAt;
        return $this;
    }

    public function getPost(): ?ChannelPostDoctrine
    {
        return $this->post;
    }

    public function setPost(?ChannelPostDoctrine $post): self
    {
        $this->post = $post;
        return $this;
    }
}
