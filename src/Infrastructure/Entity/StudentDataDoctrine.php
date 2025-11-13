<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class StudentDataDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: UserDoctrine::class, inversedBy: 'studentData')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private UserDoctrine $user;

    #[ORM\ManyToOne(targetEntity: MasterPromDoctrine::class)]
    private MasterPromDoctrine $prom;

    #[ORM\Column(type: 'date')]
    private \DateTime $startedAt;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTime $graduatedAt = null;

    #[ORM\Column(type: 'string', length: 2)]
    private string $yearName;

    #[ORM\Column(type: 'boolean')]
    private bool $isDelegate;

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

    public function getProm(): MasterPromDoctrine
    {
        return $this->prom;
    }

    public function setProm(MasterPromDoctrine $prom): self
    {
        $this->prom = $prom;
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

    public function getGraduatedAt(): ?\DateTime
    {
        return $this->graduatedAt;
    }

    public function setGraduatedAt(?\DateTime $graduatedAt): self
    {
        $this->graduatedAt = $graduatedAt;
        return $this;
    }

    public function getYearName(): string
    {
        return $this->yearName;
    }

    public function setYearName(string $yearName): self
    {
        $this->yearName = $yearName;
        return $this;
    }

    public function isDelegate(): bool
    {
        return $this->isDelegate;
    }

    public function setIsDelegate(bool $isDelegate): self
    {
        $this->isDelegate = $isDelegate;
        return $this;
    }
}