<?php declare(strict_types=1);

namespace Alumni\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class MasterPromDoctrine
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue]
    public int $id;

    #[ORM\Column(type: 'bigint')]
    public int $year;

    public function getId(): int
    {
        return $this->id;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function getCourses(): array
    {
        return $this->courses;
    }

    public function addCourses(string $course): self
    {
        if (!in_array($course, $this->courses, true))
        {
            $this->courses[] = $course;
        }

        return $this;
    }

    public function removeCourses(): self
    {
        $this->courses = [];
        return $this;
    }

    public function setCourses(array $courses): self
    {
        $this->courses = $courses;
        return $this;
    }

}