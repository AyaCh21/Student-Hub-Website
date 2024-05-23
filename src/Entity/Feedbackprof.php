<?php

namespace App\Entity;

use App\Repository\FeedbackProfRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedbackProfRepository::class)]
#[ORM\Table(name: 'Feedbackprof')]
class Feedbackprof
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: Student::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;
    #[ORM\Column(type: 'integer')]
    private ?int $studentId = null;
    #[ORM\ManyToOne(targetEntity: Professor::class)]
    #[ORM\JoinColumn(name: 'professor_id', referencedColumnName: 'id', nullable: false)]
    private ?Professor $professor = null;
    #[ORM\Column(type: 'text')]
    private ?string $feedback = null;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getProfessor(): ?Professor
    {
        return $this->professor;
    }

    public function setProfessor(?Professor $professor): self
    {
        $this->professor = $professor;
        return $this;
    }
    public function getStudent(): ?Student
    {
        return $this->student;
    }
    private ?string $studentUsername = null;


    public function getStudentUsername(): ?string
    {
        return $this->studentUsername;
    }

    public function setStudentUsername(?string $studentUsername): self
    {
        $this->studentUsername = $studentUsername;
        return $this;
    }

    public function getStudentId(): ?int
    {
        return $this->student?->getId();
    }

    public function setStudentId(?int $studentId): self
    {
        $this->studentId = $studentId;
        return $this;
    }
    public function setStudent(?Student $student): self
    {
        $this->student = $student;
        if ($student) {
            $this->studentUsername = $student->getUsername();
        }
        return $this;
    }
    public function getFeedback(): ?string
    {
        return $this->feedback;
    }

    public function setFeedback(?string $feedback): self
    {
        $this->feedback = $feedback;
        return $this;
    }
}