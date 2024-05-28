<?php

namespace App\Entity;

use App\Repository\LabInstructorRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LabInstructorRateRepository::class)]
#[ORM\Table('ratingLabInstructor')]
class LabInstructorRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: LabInstructor::class, inversedBy: 'rates')]
    #[ORM\JoinColumn(name: 'lab_instructor_id', referencedColumnName: 'id')]
    private ?LabInstructor $labInstructor = null;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'labInstructorRates')]
    #[ORM\JoinColumn(name: 'student_id', referencedColumnName: 'id')]
    private ?Student $student = null;

    #[ORM\Column(name: 'rate_value', type: "integer", nullable: false)]
    private ?int $rateValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabInstructor(): ?LabInstructor
    {
        return $this->labInstructor;
    }

    public function setLabInstructor(?LabInstructor $labInstructor): void
    {
        $this->labInstructor = $labInstructor;
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