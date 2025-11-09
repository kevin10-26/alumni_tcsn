<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class EventDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    public int $id;

    #[ORM\Column(type: 'string', length: 255)]
    public string $title;
    
    #[ORM\Column(type: 'text')]
    public string $description;

    #[ORM\Column(type: 'datetime')]
    public \DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    public \DateTime $updatedAt;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
    
    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}