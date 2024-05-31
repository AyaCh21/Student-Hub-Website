<?php

namespace App\Tests\Entity;

use App\Entity\LabInstructorRate;
use PHPUnit\Framework\TestCase;
use App\Entity\LabInstructor;
use App\Entity\Student;
use ReflectionClass;

class LabInstructorRateTest extends TestCase
{
    public function testGetId()
    {
        $labInstructorRate = new LabInstructorRate();
        $reflection = new ReflectionClass($labInstructorRate);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($labInstructorRate, 1);

        $this->assertEquals(1, $labInstructorRate->getId());
    }
    public function testSetAndGetLabInstructor()
    {
        $labInstructorRate = new LabInstructorRate();
        $labInstructor = new LabInstructor();

        $labInstructorRate->setLabInstructor($labInstructor);
        $this->assertSame($labInstructor, $labInstructorRate->getLabInstructor());
    }

    public function testSetAndGetStudent()
    {
        $labInstructorRate = new LabInstructorRate();
        $student = new Student();

        $labInstructorRate->setStudent($student);
        $this->assertSame($student, $labInstructorRate->getStudent());
    }

    public function testSetAndGetRateValue()
    {
        $labInstructorRate = new LabInstructorRate();

        $labInstructorRate->setRateValue(5);
        $this->assertEquals(5, $labInstructorRate->getRateValue());
    }


}