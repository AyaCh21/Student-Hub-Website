<?php

namespace App\Entity;

use App\Config\MaterialType;
use App\Repository\StudyMaterialRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudyMaterialRepository::class)]
#[ORM\Table ('studyMaterial')]
class StudyMaterial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    private ?MaterialType $materialType = null;

    #[ORM\ManyToOne(inversedBy: 'studyMaterial')]
    #[ORM\JoinColumn(name: 'student',nullable: false)]
    private ?Student $uploaded_by = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $uploaded_at = null;

    #[ORM\ManyToOne(inversedBy: 'studyMaterial')]
    #[ORM\JoinColumn(name:'course',nullable: false)]
    private ?Course $course= null;

    #[ORM\Column(length: 50)]
    private ?string $file_type = null;

    #[ORM\Column(length: 255)]
    private ?string $file_path = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getMaterialType(): ?MaterialType
    {
        return $this->materialType;
    }

    public function setMaterialType(?MaterialType $materialType): void
    {
        $this->materialType = $materialType;
    }

    public function getUploadedBy(): ?int
    {
        return $this->uploaded_by;
    }

    public function setUploadedBy(int $uploaded_by): static
    {
        $this->uploaded_by = $uploaded_by;

        return $this;
    }

    public function getUploadedAt(): ?\DateTimeInterface
    {
        return $this->uploaded_at;
    }

    public function setUploadedAt(\DateTimeInterface $uploaded_at): static
    {
        $this->uploaded_at = $uploaded_at;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->$course = $course;

        return $this;
    }

    public function getFileType(): ?string
    {
        return $this->file_type;
    }

    public function setFileType(string $file_type): static
    {
        $this->file_type = $file_type;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    public function setFilePath(string $file_path): static
    {
        $this->file_path = $file_path;

        return $this;
    }
}
