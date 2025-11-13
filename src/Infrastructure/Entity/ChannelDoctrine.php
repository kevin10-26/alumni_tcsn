<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Alumni\Infrastructure\Entity\ReportsDoctrine;

#[ORM\Entity]
class ChannelDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $thumbnail;

    #[ORM\Column(type: 'boolean')]
    private bool $isPublic;

    #[ORM\ManyToOne(targetEntity: UserDoctrine::class)]
    #[ORM\JoinColumn(name: 'founder_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?UserDoctrine $founder = null;

    #[ORM\OneToMany(targetEntity: ChannelMembershipDoctrine::class, mappedBy: 'channel', cascade: ['remove', 'persist'])]
    private Collection $members;

    #[ORM\OneToMany(targetEntity: ChannelPostDoctrine::class, mappedBy: 'channel', cascade: ['remove', 'persist'])]
    private Collection $posts;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->posts = new ArrayCollection();
    } 

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
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

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    public function getIsPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;
        return $this;
    }

    public function getFounder(): ?UserDoctrine
    {
        return $this->founder;
    }

    public function setFounder(?UserDoctrine $founder): self
    {
        $this->founder = $founder;
        return $this;
    }
}