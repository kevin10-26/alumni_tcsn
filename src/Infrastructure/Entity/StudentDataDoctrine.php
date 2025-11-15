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
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?MasterPromDoctrine $prom = null;

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