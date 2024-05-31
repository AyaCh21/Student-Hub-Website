<?php
// src/Entity/Feedback.php
namespace App\Entity;

use App\Repository\FeedbackRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
#[ORM\Table(name: 'Feedback')]
class Feedback
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Course::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[ORM\ManyToOne(targetEntity: Student::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\Column(type: 'text', name: 'feedback')]
    private ?string $feedback_text = null;

    private ?string $studentUsername = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;
        if ($student) {
            $this->studentUsername = $student->getUsername();
        }
        return $this;
    }

    public function getFeedbackText(): ?string
    {
        return $this->feedback_text;
    }

    public function setFeedbackText(?string $feedback_text): void
    {
        $this->feedback_text = $feedback_text;
    }

    public function getStudentUsername(): ?string
    {
        return $this->studentUsername;
    }

    public function setStudentUsername(?string $studentUsername): self
    {
        $this->studentUsername = $studentUsername;
        return $this;
    }

    public function getFeedback(): ?string
    {
        return $this->feedback_text;
    }

    public function setFeedback(?string $feedback): self
    {
        $this->feedback_text = $feedback;
        return $this;
    }
}
