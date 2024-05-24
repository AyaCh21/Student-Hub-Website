<?php

namespace App\Tests\Entity;

use App\Entity\Course;
use App\Entity\Professor;
use PHPUnit\Framework\TestCase;

class ProfessorTest extends TestCase
{
    public function testId(): void
    {
        $professor = new Professor();
        $professor->setId(1);
        $this->assertEquals(1, $professor->getId());
    }

    public function testName(): void
    {
        $professor = new Professor();
        $professor->setName("Koen Eneman");
        $this->assertEquals("Koen Eneman", $professor->getName());
    }

    public function testAddCourse(): void
    {
        $professor = new Professor();

        // Create a course
        $course = new Course();
        $course->setName("Electronics");

        // Add the course to the professor's courses
        $professor->addCourse($course);

        // Check if the course was added
        $this->assertCount(1, $professor->getCourses());
        $this->assertTrue($professor->getCourses()->contains($course));
    }

    public function testRemoveCourse(): void
    {
        $professor = new Professor();

        // Create a course
        $course = new Course();
        $course->setName("Electronics");

        // Add the course to the professor's courses
        $professor->addCourse($course);

        // Remove the course
        $professor->removeCourse($course);

        // Check if the course was removed
        $this->assertCount(0, $professor->getCourses());
        $this->assertFalse($professor->getCourses()->contains($course));
    }
}
