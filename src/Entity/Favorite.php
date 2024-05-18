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
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'StudentID', type: 'integer', nullable: true)]
    #[ORM\ManyToOne(targetEntity: "Student")]
    #[ORM\JoinColumn(name: "StudentID", referencedColumnName: "id")]
    private ?Student $student = null;

    #[ORM\Column(name: 'CourseID', type: 'integer', nullable: true)]
    #[ORM\ManyToOne(targetEntity: "Course")]
    #[ORM\JoinColumn(name: "CourseID", referencedColumnName: "id")]
    private ?Course $course = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getStudentID(): ?int
    {
        return $this->StudentID;
    }

    public function setStudentID(?int $StudentID): static
    {
        $this->StudentID = $StudentID;

        return $this;
    }

    public function getCourseID(): ?int
    {
        return $this->CourseID;
    }

    public function setCourseID(?int $CourseID): static
    {
        $this->CourseID = $CourseID;

        return $this;
    }
}
