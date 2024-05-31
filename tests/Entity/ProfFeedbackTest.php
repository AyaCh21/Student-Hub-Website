<?php

namespace App\Tests\Entity;
use PHPUnit\Framework\TestCase;
use App\Entity\ProfessorFeedback;
use App\Entity\Student;
use App\Entity\Professor;

class ProfFeedbackTest extends TestCase
{
    public function testGetAndSetId()
    {
        $professor_feedback = new ProfessorFeedback();
        $reflection = new \ReflectionClass($professor_feedback);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($professor_feedback, 1);
        $this->assertEquals(1, $professor_feedback->getId());
    }

    public function testGetAndSetStudent()
    {
        $professor_feedback = new ProfessorFeedback();
        $student = new Student();
        $student->setId(123);
        $student->setUsername('student1');
        $professor_feedback->setStudent($student);
        $this->assertSame($student, $professor_feedback->getStudent());
        $this->assertEquals('student1', $professor_feedback->getStudentUsername());
        $this->assertEquals($student, $professor_feedback->getStudent());
    }

    public function testGetAndSetProfessor()
    {
        $professor_feedback = new ProfessorFeedback();
        $professor = new Professor();
        $professor_feedback->setProfessor($professor);
        $this->assertSame($professor, $professor_feedback->getProfessor());
    }

    public function testGetAndSetFeedback()
    {
        $professor_feedback = new ProfessorFeedback();
        $professor_feedback->setFeedback('Excellent professor!');
        $this->assertEquals('Excellent professor!', $professor_feedback->getFeedback());
    }

    public function testGetAndSetStudentUsername()
    {
        $professor_feedback = new ProfessorFeedback();
        $professor_feedback->setStudentUsername('student1');
        $this->assertEquals('student1', $professor_feedback->getStudentUsername());
    }
}