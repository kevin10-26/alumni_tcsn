<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CompanyDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    public int $id;

    #[ORM\Column(type: 'string', length: 255)]
    public string $companyName;

    #[ORM\Column(type: 'string', length: 255)]
    public string $logo;
    
    public function getId(): int
    {
        return $this->id;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;
        return $this;
    }
}