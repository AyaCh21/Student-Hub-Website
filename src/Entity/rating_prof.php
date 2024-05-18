<?php

namespace App\Entity;

class rating_prof
{
    private ?int $id = null;
    private ?string $type = null;
    private ?int $uploaded_by = null;
    private ? \DateTimeInterface $uploaded_at = null;
    private ?string $file_type = null;
    private ?string $file_path = null;

    /**
     * @param int|null $id
     * @param string|null $type
     * @param int|null $uploaded_by
     * @param \DateTimeInterface|null $uploaded_at
     * @param string|null $file_type
     * @param string|null $file_path
     */
    public function __construct(?int $id, ?string $type, ?int $uploaded_by, ?\DateTimeInterface $uploaded_at, ?string $file_type, ?string $file_path)
    {
        $this->id = $id;
        $this->type = $type;
        $this->uploaded_by = $uploaded_by;
        $this->uploaded_at = $uploaded_at;
        $this->file_type = $file_type;
        $this->file_path = $file_path;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getUploadedBy(): ?int
    {
        return $this->uploaded_by;
    }

    public function setUploadedBy(?int $uploaded_by): void
    {
        $this->uploaded_by = $uploaded_by;
    }

    public function getUploadedAt(): ?\DateTimeInterface
    {
        return $this->uploaded_at;
    }

    public function setUploadedAt(?\DateTimeInterface $uploaded_at): void
    {
        $this->uploaded_at = $uploaded_at;
    }

    public function getFileType(): ?string
    {
        return $this->file_type;
    }

    public function setFileType(?string $file_type): void
    {
        $this->file_type = $file_type;
    }

    public function getFilePath(): ?string
    {
        return $this->file_path;
    }

    public function setFilePath(?string $file_path): void
    {
        $this->file_path = $file_path;
    }



}