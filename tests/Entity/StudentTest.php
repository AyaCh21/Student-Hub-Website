<?php

namespace App\Tests\Entity;

use App\Entity\Db;
use App\Entity\Student;
use App\Repository\StudentRepository;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\Exception;
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
        $student->setPassword("secret");
        $this->assertEquals("secret", $student->getPassword());
        $this->assertNotEquals("P6", $student->getPassword());

    }
    public function testGetAllStudents()
    {
        $pdoMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        // Sample data for testing
        $sampleData = [
            ['id' => 1, 'email' => 'test1@gmail.com'],
            ['id' => 2, 'email' => 'test2@gmail.com'],
            ['id' => 3, 'email' => 'test3@gmail.com']
        ];

        // Set up expectations for PDO methods
        $pdoMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
            ->method('execute');

        // Set up expectations for fetch method and sample data
        $stmtMock->expects($this->exactly(count($sampleData) + 1))
        ->method('fetch')
            ->willReturnOnConsecutiveCalls(...array_map(function ($data) {
                return $data;
            }, $sampleData));
        $students = Student::getAllStudents($pdoMock);
        $this->assertIsArray($students);
        $this->assertCount(count($sampleData), $students);

        foreach ($students as $student) {
            $this->assertInstanceOf(Student::class, $student);
        }
    }
    }
