<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UserDataDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\OneToOne(targetEntity: UserDoctrine::class, inversedBy: 'userData')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private UserDoctrine $user;

    #[ORM\Column(type: 'string', length: 255)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $lastName;

    #[ORM\Column(type: 'string')]
    private string $avatar;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $phone = null;

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

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }
}