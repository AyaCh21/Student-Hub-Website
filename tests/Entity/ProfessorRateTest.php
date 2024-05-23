<?php

namespace App\Tests\Entity;
use PHPUnit\Framework\TestCase;
use App\Entity\ProfessorRate;
use App\Entity\Professor;
use App\Entity\Student;

class ProfessorRateTest extends TestCase
{
    public function testGetAndSetId()
    {
        $professorRate = new ProfessorRate();
        $professorRate->setId(1);
        $this->assertEquals(1, $professorRate->getId());
    }

    public function testGetAndSetProfessor()
    {
        $professorRate = new ProfessorRate();
        $professor = new Professor();
        $professorRate->setProfessor($professor);
        $this->assertSame($professor, $professorRate->getProfessor());
    }

    public function testGetAndSetStudent()
    {
        $professorRate = new ProfessorRate();
        $student = new Student();
        $student->setUsername('student1');
        $professorRate->setStudent($student);
        $this->assertSame($student, $professorRate->getStudent());
        $this->assertEquals('student1', $professorRate->getStudentUsername());
    }

    public function testGetAndSetRate()
    {
        $professorRate = new ProfessorRate();
        $professorRate->setRate(5);
        $this->assertEquals(5, $professorRate->getRate());
    }

    public function testGetAndSetStudentUsername()
    {
        $professorRate = new ProfessorRate();
        $professorRate->setStudentUsername('student1');
        $this->assertEquals('student1', $professorRate->getStudentUsername());
    }
}
