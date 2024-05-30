<?php

namespace App\Tests\Entity;

use App\Entity\Course;
use App\Entity\StudyMaterial;
use App\Config\MaterialType;
use DateTime;
use PHPUnit\Framework\TestCase;

class StudyMaterialTest extends TestCase
{
    public function testGetAndSetId()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setId(1);
        $this->assertEquals(1, $studyMaterial->getId());

    }

    public function testGetAndSetUploadedBy()
    {
        $material = new StudyMaterial();
        $dateTime = new DateTime();
        $material->setUploadedAt($dateTime);
        $this->assertEquals($dateTime, $material->getUploadedAt());
    }


    public function testGetAndSetUploadedAt()
    {
        $uploadedAt = new DateTime();
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setUploadedAt($uploadedAt);
        $this->assertEquals($uploadedAt, $studyMaterial->getUploadedAt());
    }


    public function testGetAndFileType()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setFileType('pdf');
        $this->assertEquals('pdf', $studyMaterial->getFileType());
    }




    public function testGetAndSetFilePath()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setFilePath('https://a23www301.studev.groept.be/Sustainability/Team1_Sustainability_OpinionEssay.pdf ');
        $this->assertEquals('https://a23www301.studev.groept.be/Sustainability/Team1_Sustainability_OpinionEssay.pdf ', $studyMaterial->getFilePath());
        $this->assertNotEquals('path\file ', $studyMaterial->getFilePath());
    }
}
