<?php

namespace App\Tests\Entity;
use PHPUnit\Framework\TestCase;
use App\Entity\Favorite;
use App\Entity\Student;
use App\Entity\Course;

class FavoriteTest extends TestCase
{
    public function testGetId()
    {
        $favorite = new Favorite();
        $this->assertNull($favorite->getId());
    }

    public function testGetAndSetStudent()
    {
        $favorite = new Favorite();
        $student = new Student();
        $favorite->setStudent($student);
        $this->assertSame($student, $favorite->getStudent());
    }

    public function testGetAndSetCourse()
    {
        $favorite = new Favorite();
        $course = new Course();
        $favorite->setCourse($course);
        $this->assertSame($course, $favorite->getCourse());
    }
}