<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UsersDeactivatedDoctrine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: UserDoctrine::class, inversedBy: 'deactivations')]
    private UserDoctrine $user;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $startedAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $endsAt;

    #[ORM\Column(type: 'string', length: 50)]
    private string $origin;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): UserDoctrine
    {
        return $this->user;
    }

    public function setUser(UserDoctrine $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getStartedAt(): \DateTime
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTime $startedAt): self
    {
        $this->startedAt = $startedAt;
        return $this;
    }

    public function getEndsAt(): \DateTime
    {
        return $this->endsAt;
    }

    public function setEndsAt(\DateTime $endsAt): self
    {
        $this->endsAt = $endsAt;
        return $this;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;
        return $this;
    }
}