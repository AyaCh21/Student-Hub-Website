<?php
namespace App\Entity;


use App\Repository\CourseRateRepository;
use App\Repository\RatingExamRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Type;


#[ORM\Entity(repositoryClass: RatingExamRepository::class)]
#[ORM\Table('ratingExam')]
class ExamRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'rate')]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id')]
//    #[ORM\Column(name: 'course_id', type: "integer")]
    private ?Course $course = null;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'rate')]
    #[ORM\JoinColumn(name: 'student_id',referencedColumnName: 'id')]
//    #[ORM\Column(name: 'student_id', type: "integer")]
    private ?Student $student = null;

    #[ORM\Column(name: 'rate_value', type: 'integer', nullable: true)]
    private ?int $rateValue = null;

    // Getters and setters for courseId, studentId, and rateValue properties
    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): void
    {
        $this->course = $course;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): void
    {
        $this->student = $student;
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
