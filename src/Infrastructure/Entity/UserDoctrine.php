<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Alumni\Infrastructure\Entity\ReportsDoctrine;

#[ORM\Entity]
class UserDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $passwordHash;

    #[ORM\Column(type: 'string', length: 50)]
    private string $status;

    #[ORM\Column(type: 'boolean')]
    private bool $isAnonymous;

    #[ORM\OneToOne(targetEntity: UserDataDoctrine::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserDataDoctrine $userData = null;

    #[ORM\OneToMany(targetEntity: StudentDataDoctrine::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'studentId', referencedColumnName: 'user')]
    private ?Collection $studentData = null;

    #[ORM\OneToOne(targetEntity: UserJobDataDoctrine::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserJobDataDoctrine $userJobData = null;

    #[ORM\OneToMany(targetEntity: UsersDeactivatedDoctrine::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Collection $deactivations = null;

    #[ORM\ManyToMany(targetEntity: JobOfferDoctrine::class, inversedBy: 'savedBy')]
    private ?Collection $savedOffers;

    public function __construct()
    {
        $this->studentData = new ArrayCollection();
        $this->savedOffers = new ArrayCollection();
        $this->deactivations = new ArrayCollection();
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): self
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getUserData(): ?UserDataDoctrine
    {
        return $this->userData;
    }

    public function setUserData(?UserDataDoctrine $userData): self
    {
        $this->userData = $userData;
        if ($userData !== null) {
            $userData->setUser($this);
        }
        return $this;
    }

    public function getStudentData(): ?Collection
    {
        return $this->studentData;
    }

    public function setStudentData(Collection $studentData): self
    {
        $this->studentData = $studentData;
        return $this;
    }

    public function getUserJobData(): ?UserJobDataDoctrine
    {
        return $this->userJobData;
    }

    public function setUserJobData(?UserJobDataDoctrine $userJobData): self
    {
        $this->userJobData = $userJobData;
        if ($userJobData !== null) {
            $userJobData->setUser($this);
        }
        return $this;
    }

    public function getSavedOffers(): ?Collection
    {
        return $this->savedOffers;
    }

    public function saveNewOffer(JobOfferDoctrine $jobOffer): self
    {
        if (!$this->savedOffers->contains($jobOffer))
        {
            $this->savedOffers->add($jobOffer);
        }

        return $this;
    }

    public function unsaveOffer(JobOfferDoctrine $jobOffer): self
    {
        if ($this->savedOffers->contains($jobOffer))
        {
            $this->savedOffers->removeElement($jobOffer);
        }

        return $this;
    }

    public function isAnonymous(): bool
    {
        return $this->isAnonymous;
    }

    public function setAnonymousStatus(bool $status): self
    {
        $this->isAnonymous = $status;
        return $this;
    }

    public function getDeactivations(): ?Collection
    {
        return $this->deactivations;
    }

    public function addDeactivation(UsersDeactivatedDoctrine $deactivation): self
    {
        if (!$this->deactivations->contains($deactivation))
        {
            $this->deactivations->add($deactivation);
        }
        return $this;
    }

    public function removeDeactivation(UsersDeactivatedDoctrine $deactivation): self
    {
        if ($this->deactivations->contains($deactivation))
        {
            $this->deactivations->remove($deactivation);
        }
        return $this;
    }

    public function setDeactivations(?Collection $deactivations): self
    {
        $this->deactivations = $deactivations;
        return $this;
    }
}