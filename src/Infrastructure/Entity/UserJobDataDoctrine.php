<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UserJobDataDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\OneToOne(targetEntity: UserDoctrine::class, inversedBy: 'userJobData')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private UserDoctrine $user;

    #[ORM\Column(type: 'string', length: 255)]
    private string $company;

    #[ORM\Column(type: 'string', length: 255)]
    private string $position;

    #[ORM\Column(type: 'date')]
    private \DateTime $startDate;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTime $endDate = null;

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

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }
}