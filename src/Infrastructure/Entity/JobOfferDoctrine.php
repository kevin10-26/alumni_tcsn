<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Alumni\Infrastructure\Entity\ReportsDoctrine;

#[ORM\Entity]
class JobOfferDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    public int $id;

    #[ORM\Column(type: 'string', length: 255)]
    public string $jobName;

    #[ORM\Column(type: 'text')]
    public string $jobDescription;

    #[ORM\ManyToOne(targetEntity: CompanyDoctrine::class)]
    #[JoinColumn(name: 'company', referencedColumnName: 'id')]
    public CompanyDoctrine $company;

    #[ORM\Column(type: 'string', length: 255)]
    public string $jobType;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    public ?string $minimumDuration;

    #[ORM\ManyToOne(targetEntity: UserDoctrine::class)]
    #[ORM\JoinColumn(name: 'author', referencedColumnName: 'id')]
    public UserDoctrine $author;

    #[ORM\ManyToMany(targetEntity: UserDoctrine::class, mappedBy: 'savedOffers')]
    public Collection $savedBy;

    #[ORM\ManyToOne(targetEntity: ReportsDoctrine::class, inversedBy: 'jobOffer')]
    #[ORM\JoinColumn(name: 'reports_id', referencedColumnName: 'id', nullable: true)]
    private ?ReportsDoctrine $reports = null;

    public function __construct()
    {
        $this->savedBy = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getJobName(): string
    {
        return $this->jobName;
    }

    public function setJobName(string $jobName): self
    {
        $this->jobName = $jobName;
        return $this;
    }

    public function getJobDescription(): string
    {
        return $this->jobDescription;
    }

    public function setJobDescription(string $jobDescription): self
    {
        $this->jobDescription = $jobDescription;
        return $this;
    }

    public function getCompany(): CompanyDoctrine
    {
        return $this->company;
    }

    public function setCompany(CompanyDoctrine $company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getJobType(): string
    {
        return $this->jobType;
    }

    public function setJobType(string $jobType): self
    {
        $this->jobType = $jobType;
        return $this;
    }

    public function getMinimumDuration(): ?string
    {
        return $this->minimumDuration;
    }

    public function setMinimumDuration(?string $minimumDuration): self
    {
        $this->minimumDuration = $minimumDuration;
        return $this;
    }

    public function getAuthor(): UserDoctrine
    {
        return $this->author;
    }

    public function setAuthor(UserDoctrine $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getReports(): ?ReportsDoctrine
    {
        return $this->reports;
    }

    public function setReports(?ReportsDoctrine $reports): self
    {
        $this->reports = $reports;
        return $this;
    }
}