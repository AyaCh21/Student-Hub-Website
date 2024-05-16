<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[ORM\Table ('course')]

class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    #[ORM\JoinColumn(name:'professor_id',nullable: false)]
    private ?Professor $professor = null;

    #[ORM\OneToMany(targetEntity: StudyMaterial::class, mappedBy: 'course')]
    private Collection $studyMaterials;

    #[ORM\Column(nullable: true)]
    private ?int $phase = null;

    #[ORM\Column]
    private ?int $semester = null;

    #[ORM\Column(length: 150)]
    private ?string $specialisation = null;

    #[ORM\Column]
    private ?int $ects = null;

    #[ORM\Column]
    private ?bool $hasLab = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getProfessor(): ?Professor
    {
        return $this->professor;
    }

    public function setProfessor(?Professor $professor): static
    {
        $this->professor = $professor;

        return $this;
    }

    /**
     * @return Collection<int, StudyMaterial>
     */
    public function getStudyMaterials()
    {
        return $this->studyMaterials;
    }
    public function addStudyMaterial(StudyMaterial $material): static
    {
        if (!$this->studyMaterials->contains($material)) {
            $this->studyMaterials->add($material);
            $material->setCourse($this);
        }
        return $this;
    }

    public function removeStudyMaterial(StudyMaterial $material): static
    {
        if ($this->studyMaterials->removeElement($material)) {
            if ($material->getCourse() === $this) {
                $material->setCourse(null);
            }
        }

        return $this;
    }

    public function getPhase(): ?int
    {
        return $this->phase;
    }

    public function setPhase(?int $phase): static
    {
        $this->phase = $phase;

        return $this;
    }

    public function getSemester(): ?int
    {
        return $this->semester;
    }

    public function setSemester(int $semester): static
    {
        $this->semester = $semester;

        return $this;
    }

    public function getSpecialisation(): ?string
    {
        return $this->specialisation;
    }

    public function setSpecialisation(string $specialisation): static
    {
        $this->specialisation = $specialisation;

        return $this;
    }

    public function getEcts(): ?int
    {
        return $this->ects;
    }

    public function setEcts(int $ects): static
    {
        $this->ects = $ects;

        return $this;
    }

    public function hasLab(): ?bool
    {
        return $this->hasLab;
    }

    public function setHasLab(bool $hasLab): static
    {
        $this->hasLab = $hasLab;

        return $this;
    }
}
