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
    #[ORM\JoinColumn(name:'professor',nullable: false)]
    private ?Professor $professor = null;

    #[ORM\OneToMany(targetEntity: StudyMaterial::class, mappedBy: 'course')]
    private Collection $studyMaterials;

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
}
