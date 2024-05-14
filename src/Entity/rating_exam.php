<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRateRepository::class)]
#[ORM\Table('rating_exam')]
class rating_exam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'rate')]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id')]
    private ?Course $course = null;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'rate')]
    #[ORM\JoinColumn(name: 'student_id', referencedColumnName: 'id')]
    private ?Student $student = null;

    #[ORM\Column]
    private ?int $rate_value = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

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
        return $this->rate_value;
    }

    public function setRateValue(?int $rate_value): void
    {
        $this->rate_value = $rate_value;
    }



}