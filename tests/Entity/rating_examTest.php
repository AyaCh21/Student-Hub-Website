<?php

namespace App\Tests\Entity;

use App\Entity\rating_exam;
use PHPUnit\Framework\TestCase;

class rating_examTest extends TestCase
{
    public function testGetAndSetCourseId()
    {
        $ratingExam = new rating_exam();
        $ratingExam->setCourseId(1);
        $this->assertEquals(1, $ratingExam->getCourseId());
    }

    public function testGetAndSetStudentId()
    {
        $ratingExam = new rating_exam();
        $ratingExam->setStudentId(1);
        $this->assertEquals(1, $ratingExam->getStudentId());
    }

    public function testGetAndSetRateValue()
    {
        $ratingExam = new rating_exam();
        $ratingExam->setRateValue(5);
        $this->assertEquals(5, $ratingExam->getRateValue());
    }
}
