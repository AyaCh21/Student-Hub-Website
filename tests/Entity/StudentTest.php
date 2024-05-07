<?php

namespace App\Tests\Entity;

use App\Entity\Student;
use PHPUnit\Framework\TestCase;

class StudentTest extends TestCase
{
    public function testGetId()
    {
        $student = new Student();
        $student->setId(1);
        $this->assertEquals(1, $student->getId());
    }

    public function testSetId()
    {
        $student = new Student();
        $student->setId(1);
        $this->assertEquals(1, $student->getId());
    }

    public function testGetUsername()
    {
        $student = new Student();
        $student->setUsername("Aya");
        $this->assertEquals("Aya", $student->getUsername());
    }

    public function testSetUsername()
    {
        $student = new Student();
        $student->setUsername("Dele");
        $this->assertEquals("Dele", $student->getUsername());
    }

    public function testGetEmail()
    {
        $student = new Student();
        $student->setEmail("rohan.bhattaram@student.kuleuven.be");
        $this->assertEquals("rohan.bhattaram@student.kuleuven.be", $student->getEmail());
    }

    public function testSetEmail()
    {
        $student = new Student();
        $student->setEmail("charlie.brown@student.kuleuven.be");
        $this->assertEquals("charlie.brown@student.kuleuven.be", $student->getEmail());

        $this->assertNotEquals("le@gmail.com", $student->getEmail());
    }

    public function testGetPassword()
    {
        $student = new Student();
        $student->setPassword("secret");
        $this->assertEquals("secret", $student->getPassword());
        $this->assertNotEquals("password123", $student->getPassword());
    }

    public function testSetPassword()
    {
        $student = new Student();
        $student->setPassword("Password456");
        $this->assertEquals("Password456", $student->getPassword());
        $this->assertNotEquals("P6", $student->getPassword());

    }
}
