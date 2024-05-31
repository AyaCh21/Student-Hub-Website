<?php

namespace App\Tests\Entity;

use App\Entity\LabRate;
use PHPUnit\Framework\TestCase;
use App\Entity\Course;
use App\Entity\Student;
use ReflectionClass;

class LabRateTest extends TestCase
{
    public function testGetId()
    {
        $labRate = new LabRate();
        $reflection = new ReflectionClass($labRate);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($labRate, 1);

        $this->assertEquals(1, $labRate->getId());
    }
    public function testSetAndGetCourse()
    {
        $labRate = new LabRate();
        $course = new Course();

        $labRate->setCourse($course);
        $this->assertSame($course, $labRate->getCourse());
    }
    public function testSetAndGetStudent()
    {
        $labRate = new LabRate();
        $student = new Student();

        $labRate->setStudent($student);
        $this->assertSame($student, $labRate->getStudent());
    }
    public function testSetAndGetRateValue()
    {
        $labRate = new LabRate();

        $labRate->setRateValue(5);
        $this->assertEquals(5, $labRate->getRateValue());
    }




}