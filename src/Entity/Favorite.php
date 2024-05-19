<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
#[ORM\Table('Favorite')]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Student")]
    #[ORM\JoinColumn(name: "StudentID", referencedColumnName: "id", nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Course")]
    #[ORM\JoinColumn(name: "CourseID", referencedColumnName: "id", nullable: false)]
    private ?Course $course = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }
}
