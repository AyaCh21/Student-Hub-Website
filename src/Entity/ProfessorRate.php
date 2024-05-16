<?php

namespace App\Entity;

use App\Repository\ProfessorRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessorRateRepository::class)]
#[ORM\Table('ratingProf')]
class ProfessorRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: Professor::class, inversedBy: 'rate')]
    #[ORM\JoinColumn(name: 'professor_id',referencedColumnName: 'id')]
    private ?Professor $professor = null;
    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'rate')]
    #[ORM\JoinColumn(name: 'student_id',referencedColumnName: 'id')]
    private ?Student $student = null;
    #[ORM\Column]
    private ?int $rate_value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getProfessor(): ?Professor
    {
        return $this->professor;
    }

    public function setProfessor(?Professor $professor): void
    {
        $this->professor = $professor;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): void
    {
        $this->student = $student;
    }

    public function getRate(): ?int
    {
        return $this->rate_value;
    }

    public function setRate(int $rate): static
    {
        $this->rate_value = $rate;

        return $this;
    }







}