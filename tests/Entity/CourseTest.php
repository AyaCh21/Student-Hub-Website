<?php

namespace App\Tests\Entity;

use App\Entity\Course;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

class CourseTest extends TestCase
{

    public function testGetId()
    {
        $course = new Course();
        $course->setId(1);
        $this->assertEquals(1, $course->getId());
    }

    public function testSetId()
    {
        $course = new Course();
        $course->setId(1);
        $this->assertEquals(1, $course->getId());
    }

    public function testGetName()
    {
        $course = new Course();
        $course->setName("Mathematical Modelling");
        $this->assertEquals("Mathematical Modelling", $course->getName());
    }

    public function testSetName()
    {
        $course = new Course();
        $course->setName("Chemistry");
        $this->assertEquals("Chemistry", $course->getName());
    }

    public function testGetProfessor()
    {
        $course = new Course();
        $course->setProfessor(1);
        $this->assertEquals(1, $course->getProfessor());
    }

    public function testSetProfessor()
    {
        $course = new Course();
        $course->setProfessor(6);
        $this->assertEquals(6, $course->getProfessor());
    }

    public function testFailSetProfessor()
    {
        $course = new Course();
        $course->setProfessor(6);
        $this->assertNotEquals(7, $course->getProfessor());
    }
    public function testFailSetName()
    {
        $course = new Course();
        $course->setName("Chemistry");
        $this->assertNotEquals("Biology", $course->getName());
        $this->assertEquals("Chemistry", $course->getName());
    }
    public function testFailSetId()
    {
        $course = new Course();
        $course->setId(1);
        $this->assertNotEquals(2, $course->getId());
    }
    #[group('deprecated')]
    #[doesNotPerformAssertions]
    public function testSetIdWithDeprecation()
    {
        $course = new Course();
        $course->setId(1);
    }

    #[group('deprecated')]
    #[doesNotPerformAssertions]
    public function testSetProfessorWithDeprecation()
    {
        $course = new Course();
        $course->setProfessor(6);
    }
}