<?php

namespace App\Entity;

use App\Config\MaterialType;
use App\Repository\StudyMaterialRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudyMaterialRepository::class)]
#[ORM\Table ('StudyMaterial')]
class StudyMaterial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'studyMaterials')]
    #[ORM\JoinColumn(name: 'uploaded_by', referencedColumnName: 'id', nullable: false)]
    private ?Student $uploaded_by = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $uploaded_at = null;

    #[ORM\ManyToOne(inversedBy: 'studyMaterials')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    #[ORM\Column(type: Types::TEXT, length: 50)]
    private ?string $file_type = null;

    #[ORM\Column(type: Types::TEXT, length: 255)]
    private ?string $file_path = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;
    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $test_pdf = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
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

    public function getUploadedBy(): ?Student
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

    public function setUploadedAt(?\DateTimeInterface $uploaded_at): self
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
        $this->course = $course;
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;
        return $this;
    }
    public function getTestPdf()
    {
        return $this->test_pdf;
    }

    public function setTestPdf($test_pdf): self
    {
        $this->test_pdf = $test_pdf;
        return $this;
    }
}
