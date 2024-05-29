<?php

namespace App\Entity;

use App\Repository\LabRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LabRateRepository::class)]
#[ORM\Table('ratingLab')]
class LabRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'labRates')]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id')]
    private ?Course $course = null;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'labRates')]
    #[ORM\JoinColumn(name: 'student_id', referencedColumnName: 'id')]
    private ?Student $student = null;

    #[ORM\Column(name: 'rate_value', type: "integer", nullable: false)]
    private ?int $rateValue = null;

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->rateValue;
    }

    public function setRateValue(int $rateValue): void
    {
        $this->rateValue = $rateValue;
    }

}