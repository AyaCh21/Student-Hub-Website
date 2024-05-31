<?php

namespace App\Tests\Entity;


use PHPUnit\Framework\TestCase;
use App\Entity\LabInstructor;
use App\Entity\Course;
use Doctrine\Common\Collections\ArrayCollection;

class LabInstructorTest extends TestCase
{
    public function testGetId()
    {
        $labInstructor = new LabInstructor();
        $labInstructor->setId(1);

        $this->assertEquals(1, $labInstructor->getId());
    }

    public function testSetAndGetName()
    {
        $labInstructor = new LabInstructor();
        $name = 'John Doe';

        $labInstructor->setName($name);
        $this->assertEquals($name, $labInstructor->getName());
    }

    public function testGetCourses()
    {
        $labInstructor = new LabInstructor();
        $this->assertInstanceOf(ArrayCollection::class, $labInstructor->getCourses());
        $this->assertCount(0, $labInstructor->getCourses());
    }
    public function testRemoveCourse()
    {
        $labInstructor = new LabInstructor();
        $course = $this->createMock(Course::class);

        // Mock the removeLabInstructor method
        $course->expects($this->once())
            ->method('removeLabInstructor')
            ->with($this->equalTo($labInstructor));

        $labInstructor->getCourses()->add($course);

        $this->assertCount(1, $labInstructor->getCourses());
        $labInstructor->removeCourse($course);
        $this->assertCount(0, $labInstructor->getCourses());
    }

}
