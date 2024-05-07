<?php

namespace App\Tests\Entity;

use App\Entity\Professor;
use PHPUnit\Framework\TestCase;

use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Group;
class ProfessorTest extends TestCase
{
    public function testGetId()
    {
        $professor = new Professor();
        $professor->setId(1);
        $this->assertEquals(1, $professor->getId());
    }

    public function testGetName()
    {
        $professor = new Professor();
        $professor->setName("Arn Mignon");
        $this->assertEquals("Arn Mignon", $professor->getName());
    }

    public function testSetName()
    {
        $professor = new Professor();
        $professor->setName("Joost Vennekens");
        $this->assertEquals("Joost Vennekens", $professor->getName());
    }

    public function testGetCourseId()
    {
        $professor = new Professor();
        $professor->setCourseId(1);
        $this->assertEquals(1, $professor->getCourseId());
    }

    public function testSetCourseId()
    {
        $professor = new Professor();
        $professor->setCourseId(5);
        $this->assertEquals(5, $professor->getCourseId());
    }
    public function testSetInvalidCourseId()
    {
        $professor = new Professor();
        $invalidCourseId = -1; // Assuming -1 is an invalid course ID
        $professor->setCourseId(2);

        // Now, verify that the course ID has not been set to the invalid value
        $this->assertEquals(2, $professor->getCourseId());
        $this->assertNotEquals($invalidCourseId, $professor->getCourseId());
    }

    public function testGetNameFail()
    {
        $professor = new Professor();
        $professor->setName("Arn Mignon");
        $this->assertEquals("Arn Mignon", $professor->getName());
        $this->assertNotEquals("John Doe", $professor->getName());
    }

    public function testSetNameFail()
    {
        $professor = new Professor();
        $professor->setName("Joost Vennekens");
        $this->assertNotEquals("Jane Smith", $professor->getName());
    }

    public function testGetCourseIdFail()
    {
        $professor = new Professor();
        $professor->setCourseId(1);
        $this->assertNotEquals(2, $professor->getCourseId());
    }

    public function testSetCourseIdFail()
    {
        $professor = new Professor();
        $professor->setCourseId(5);
        $this->assertNotEquals(6, $professor->getCourseId());
    }

    #[group('deprecated')]
    #[doesNotPerformAssertions]
    public function testSetIdWithDeprecation()
    {
        $professor = new Professor();
        $professor->setId(1);
    }

    #[group('deprecated')]
    #[doesNotPerformAssertions]
    public function testSetCourseIdWithDeprecation()
    {
        $professor = new Professor();
        $professor->setCourseId(5);
    }
}
