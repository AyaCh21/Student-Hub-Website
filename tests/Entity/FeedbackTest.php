<?php

namespace App\Tests\Entity;


use PHPUnit\Framework\TestCase;
use App\Entity\Feedback;
use App\Entity\Course;
use App\Entity\Student;

class FeedbackTest extends TestCase
{
    public function testGetAndSetId()
    {
        $feedback = new Feedback();
        $reflection = new \ReflectionClass($feedback);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($feedback, 1);
        $this->assertEquals(1, $feedback->getId());
    }

    public function testGetAndSetCourse()
    {
        $feedback = new Feedback();
        $course = new Course();
        $feedback->setCourse($course);
        $this->assertSame($course, $feedback->getCourse());
    }

    public function testGetAndSetStudent()
    {
        $feedback = new Feedback();
        $student = new Student();
        $student->setId(123);
        $student->setUsername('student1');
        $feedback->setStudent($student);
        $this->assertSame($student, $feedback->getStudent());
        $this->assertEquals('student1', $feedback->getStudentUsername());
        $this->assertEquals($student, $feedback->getStudent());
    }

    public function testGetAndSetStudentId()
    {
        $feedback = new Feedback();
        $student = new Student();
        $student->setId(123);
        $student->setUsername('testuser');
        $feedback->setStudent($student);
        $this->assertEquals($student, $feedback->getStudent());
        }

    public function testGetAndSetStudentUsername()
    {
        $feedback = new Feedback();
        $feedback->setStudentUsername('student1');
        $this->assertEquals('student1', $feedback->getStudentUsername());
    }

    public function testGetAndSetFeedbackText()
    {
        $feedback = new Feedback();
        $feedback->setFeedbackText('Great course!');
        $this->assertEquals('Great course!', $feedback->getFeedbackText());
    }
}