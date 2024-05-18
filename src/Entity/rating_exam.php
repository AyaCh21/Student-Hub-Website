<?php
namespace App\Entity;

use App\Repository\CourseRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRateRepository::class)]
#[ORM\Table('ratingExam')]
class rating_exam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'course_id', type: 'integer', nullable: true)]
    private ?int $courseId = null;

    #[ORM\Column(name: 'student_id', type: 'integer', nullable: true)]
    private ?int $studentId = null;

    #[ORM\Column(name: 'rate_value', type: 'integer', nullable: true)]
    private ?int $rateValue = null;

    // Getters and setters for courseId, studentId, and rateValue properties
    public function getCourseId(): ?int
    {
        return $this->courseId;
    }

    public function setCourseId(?int $courseId): void
    {
        $this->courseId = $courseId;
    }

    public function getStudentId(): ?int
    {
        return $this->studentId;
    }

    public function setStudentId(?int $studentId): void
    {
        $this->studentId = $studentId;
    }

    public function getRateValue(): ?int
    {
        return $this->rateValue;
    }

    public function setRateValue(?int $rateValue): void
    {
        $this->rateValue = $rateValue;
    }
}
