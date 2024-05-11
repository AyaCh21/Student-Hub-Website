<?php

namespace App\Entity;

use App\Repository\ProfessorRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessorRateRepository::class)]
#[ORM\Table('professorRate')]
class ProfessorRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;
    #[ORM\ManyToOne(targetEntity: Professor::class, inversedBy: 'professorRate')]
    #[ORM\JoinColumn(name: 'professor',referencedColumnName: 'id')]
    protected ?Professor $professor = null;
    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'professorRate')]
    #[ORM\JoinColumn(name: 'student',referencedColumnName: 'id')]
    protected ?Student $student = null;

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







}