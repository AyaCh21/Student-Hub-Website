<?php


namespace App\Tests\Entity;

use App\Entity\Course;
use App\Entity\Professor;
use App\Entity\StudyMaterial;
use PHPUnit\Framework\TestCase;

class CourseTest extends TestCase
{
    public function testId(): void
    {
        $course = new Course();
        $course->setId(1);
        $this->assertEquals(1, $course->getId());
        $this->assertNotEquals(2, $course->getId()); // Added assertion for inequality
    }

    public function testName(): void
    {
        $course = new Course();
        $course->setName("Test Course");
        $this->assertEquals("Test Course", $course->getName());
        $this->assertNotEquals("Another Course", $course->getName()); // Added assertion for inequality
    }

    public function testProfessor(): void
    {
        $course = new Course();
        $professor = new Professor();
        $course->setProfessor($professor);
        $this->assertEquals($professor, $course->getProfessor());
    }

    public function testPhase(): void
    {
        $course = new Course();
        $course->setPhase(1);
        $this->assertEquals(1, $course->getPhase());
        $this->assertNotEquals(2, $course->getPhase()); // Added assertion for inequality
    }

    public function testSemester(): void
    {
        $course = new Course();
        $course->setSemester(2);
        $this->assertEquals(2, $course->getSemester());
        $this->assertNotEquals(1, $course->getSemester()); // Added assertion for inequality
    }

    public function testSpecialisation(): void
    {
        $course = new Course();
        $course->setSpecialisation("Electronics");
        $this->assertEquals("Electronics", $course->getSpecialisation());
        $this->assertNotEquals("Computer Science", $course->getSpecialisation()); // Added assertion for inequality
    }

    public function testEcts(): void
    {
        $course = new Course();
        $course->setEcts(5);
        $this->assertEquals(5, $course->getEcts());
        $this->assertNotEquals(10, $course->getEcts()); // Added assertion for inequality
    }

    public function testHasLab(): void
    {
        $course = new Course();
        $course->setHasLab(true);
        $this->assertTrue($course->hasLab());

    }


}
