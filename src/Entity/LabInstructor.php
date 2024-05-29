<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LabInstructorRepository;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: LabInstructorRepository::class)]
#[ORM\Table(name: 'LabInstructor')]
class LabInstructor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 100)]
    private string $name;

    // Getters and setters

    #[ORM\ManyToMany(targetEntity: Course::class, mappedBy: 'labInstructors')]
    private Collection $courses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCourses(): Collection
    {
        return $this->courses;
    }
    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            $course->removeLabInstructor($this);
        }
        return $this;
    }




}