<?php

namespace App\Tests\Entity;
use PHPUnit\Framework\TestCase;
use App\Entity\Feedbackprof;
use App\Entity\Student;
use App\Entity\Professor;

class ProfFeedbackTest extends TestCase
{
    public function testGetAndSetId()
    {
        $feedbackprof = new Feedbackprof();
        $reflection = new \ReflectionClass($feedbackprof);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($feedbackprof, 1);
        $this->assertEquals(1, $feedbackprof->getId());
    }

    public function testGetAndSetStudent()
    {
        $feedbackprof = new Feedbackprof();
        $student = new Student();
        $student->setId(123);
        $student->setUsername('student1');
        $feedbackprof->setStudent($student);
        $this->assertSame($student, $feedbackprof->getStudent());
        $this->assertEquals('student1', $feedbackprof->getStudentUsername());
        $this->assertEquals(123, $feedbackprof->getStudentId());
    }

    public function testGetAndSetProfessor()
    {
        $feedbackprof = new Feedbackprof();
        $professor = new Professor();
        $feedbackprof->setProfessor($professor);
        $this->assertSame($professor, $feedbackprof->getProfessor());
    }

    public function testGetAndSetFeedback()
    {
        $feedbackprof = new Feedbackprof();
        $feedbackprof->setFeedback('Excellent professor!');
        $this->assertEquals('Excellent professor!', $feedbackprof->getFeedback());
    }

    public function testGetAndSetStudentUsername()
    {
        $feedbackprof = new Feedbackprof();
        $feedbackprof->setStudentUsername('student1');
        $this->assertEquals('student1', $feedbackprof->getStudentUsername());
    }
}