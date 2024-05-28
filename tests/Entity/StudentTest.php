<?php

namespace App\Tests\Entity;

use App\Entity\Db;
use App\Entity\Student;
use App\Entity\StudyMaterial;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\Collection;


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

    public function testGetPhase()
    {
        $student = new Student();
        $student->setPhase(2);
        $this->assertEquals(2, $student->getPhase());
    }

    public function testSetPhase()
    {
        $student = new Student();
        $student->setPhase(2);
        $this->assertEquals(2, $student->getPhase());
    }

    public function testGetSpecialisation()
    {
        $student = new Student();
        $student->setSpecialisation("Computer Science");
        $this->assertEquals("Computer Science", $student->getSpecialisation());
    }

    public function testSetSpecialisation()
    {
        $student = new Student();
        $student->setSpecialisation("Mathematics");
        $this->assertEquals("Mathematics", $student->getSpecialisation());
    }

    public function testEraseCredentials()
    {
        $student = new Student();
        $student->eraseCredentials();
        // Ensure method does not throw exceptions
        $this->assertTrue(true);
    }

    public function testGetUserIdentifier()
    {
        $student = new Student();
        $student->setId(1);
        $this->assertEquals("1", $student->getUserIdentifier());
    }

    public function testGetRoles()
    {
        $student = new Student();
        $student->setRoles(["ROLE_STUDENT", "ROLE_USER"]);
        $this->assertContains("ROLE_STUDENT", $student->getRoles());
        $this->assertContains("ROLE_USER", $student->getRoles());
    }

    public function testSetRoles()
    {
        $student = new Student();
        $student->setRoles(["ROLE_STUDENT", "ROLE_USER"]);
        $this->assertContains("ROLE_STUDENT", $student->getRoles());
        $this->assertContains("ROLE_USER", $student->getRoles());
        }

}