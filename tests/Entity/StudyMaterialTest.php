<?php

namespace App\Tests\Entity;

use App\Entity\StudyMaterial;
use App\Config\MaterialType;
use PHPUnit\Framework\TestCase;

class StudyMaterialTest extends TestCase
{
    public function testGetId()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setId(1);
        $this->assertEquals(1, $studyMaterial->getId());

    }

    public function testSetId()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setId(1);
        $this->assertEquals(1, $studyMaterial->getId());
    }

    public function testGetMaterialType()
    {
        $materialType = MaterialType::lecture;
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setMaterialType($materialType);
        $this->assertEquals($materialType, $studyMaterial->getMaterialType());
    }

    public function testSetMaterialType()
    {
        $materialType = MaterialType::lecture;
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setMaterialType($materialType);
        $this->assertEquals($materialType, $studyMaterial->getMaterialType());
    }

    public function testGetUploadedBy()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setUploadedBy(1);
        $this->assertEquals(1, $studyMaterial->getUploadedBy());
    }

    public function testSetUploadedBy()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setUploadedBy(1);
        $this->assertEquals(1, $studyMaterial->getUploadedBy());
    }

    public function testGetUploadedAt()
    {
        $uploadedAt = new \DateTime();
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setUploadedAt($uploadedAt);
        $this->assertEquals($uploadedAt, $studyMaterial->getUploadedAt());
    }

    public function testSetUploadedAt()
    {
        $uploadedAt = new \DateTime();
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setUploadedAt($uploadedAt);
        $this->assertEquals($uploadedAt, $studyMaterial->getUploadedAt());
    }

    public function testGetCourseId()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setCourseId(1);
        $this->assertEquals(1, $studyMaterial->getCourseId());
    }

    public function testSetCourseId()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setCourseId(1);
        $this->assertEquals(1, $studyMaterial->getCourseId());
    }

    public function testGetFileType()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setFileType('pdf');
        $this->assertEquals('pdf', $studyMaterial->getFileType());
    }

    public function testSetFileType()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setFileType('pdf');
        $this->assertEquals('pdf', $studyMaterial->getFileType());
    }

    public function testGetFilePath()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setFilePath('https://a23www301.studev.groept.be/Sustainability/Team1_Sustainability_OpinionEssay.pdf ');
        $this->assertEquals('https://a23www301.studev.groept.be/Sustainability/Team1_Sustainability_OpinionEssay.pdf ', $studyMaterial->getFilePath());
        $this->assertNotEquals('path\file ', $studyMaterial->getFilePath());

    }

    public function testSetFilePath()
    {
        $studyMaterial = new StudyMaterial();
        $studyMaterial->setFilePath('https://a23www301.studev.groept.be/Sustainability/Team1_Sustainability_OpinionEssay.pdf ');
        $this->assertEquals('https://a23www301.studev.groept.be/Sustainability/Team1_Sustainability_OpinionEssay.pdf ', $studyMaterial->getFilePath());
    }
}
