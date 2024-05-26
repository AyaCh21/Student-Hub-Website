<?php

namespace App\Entity;

use App\Repository\ProfessorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessorRepository::class)]
#[ORM\Table ('Professor')]
class Professor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'professor')]
    private Collection $courses;

    #[ORM\OneToMany(targetEntity: ProfessorRate::class, mappedBy: 'professor')]
    private Collection $rates;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->rates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setProfessor($this);
        }
        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            if ($course->getProfessor() === $this) {
                $course->setProfessor(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, ProfessorRate>
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function addRate(ProfessorRate $rate): static
    {
        if (!$this->rates->contains($rate)) {
            $this->rates->add($rate);
            $rate->setProfessor($this);
        }
        return $this;
    }

    public function removeRate(ProfessorRate $rate): static
    {
        if ($this->rates->removeElement($rate)) {
            if ($rate->getProfessor() === $this) {
                $rate->setProfessor(null);
            }
        }
        return $this;
    }
}
