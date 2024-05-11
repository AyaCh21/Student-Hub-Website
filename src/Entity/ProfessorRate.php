<?php

namespace App\Entity;

use App\Repository\ProfessorRateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessorRateRepository::class)]
class ProfessorRate
{
    protected ?int $id = null;
    protected ?Professor $professor = null;
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