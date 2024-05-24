<?php

namespace App\Tests\Entity;


use App\Entity\Course;
use App\Entity\Student;
use PHPUnit\Framework\TestCase;
use App\Entity\ExamRate;

class rating_examTest extends TestCase
{
    public function testGetAndSetCourseId()
    {
        $ratingExam = new ExamRate();
        $course = new Course();
        $course->setId(101);
        $ratingExam->setCourse($course);
        $this->assertEquals($course, $ratingExam->getCourse());
    }

    public function testGetAndSetStudentId()
    {
        $ratingExam = new ExamRate();
        $student = new Student();
        $student->setId(202);
        $ratingExam->setStudent($student);
        $this->assertEquals($student, $ratingExam->getStudent());
    }

    public function testGetAndSetRateValue()
    {
        $ratingExam = new ExamRate();
        $rateValue = 5;
        $ratingExam->setRateValue($rateValue);
        $this->assertEquals($rateValue, $ratingExam->getRateValue());
    }

    public function testGetId()
    {
        $ratingExam = new ExamRate();

        $reflection = new \ReflectionClass($ratingExam);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($ratingExam, 1);

        $this->assertEquals(1, $ratingExam->getId());
    }
}
