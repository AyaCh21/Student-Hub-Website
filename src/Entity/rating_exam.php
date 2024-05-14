<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="rating_exam")
 */
class rating_exam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column
     */
    private ?int $id = null;
    /**
     * @ORM\Column
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private ?int $course_id = null;
    /**
     * @ORM\Column
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private ?int $student_id = null;
    /**
     * @ORM\Column
     */
    private ?int $rate_value = null;

    /**
     * @param int|null $id
     * @param int|null $course_id
     * @param int|null $student_id
     * @param int|null $rate_value
     */
    public function __construct(?int $id, ?int $course_id, ?int $student_id, ?int $rate_value)
    {
        $this->id = $id;
        $this->course_id = $course_id;
        $this->student_id = $student_id;
        $this->rate_value = $rate_value;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCourseId(): ?int
    {
        return $this->course_id;
    }

    public function setCourseId(?int $course_id): void
    {
        $this->course_id = $course_id;
    }

    public function getStudentId(): ?int
    {
        return $this->student_id;
    }

    public function setStudentId(?int $student_id): void
    {
        $this->student_id = $student_id;
    }

    public function getRateValue(): ?int
    {
        return $this->rate_value;
    }

    public function setRateValue(?int $rate_value): void
    {
        $this->rate_value = $rate_value;
    }



}