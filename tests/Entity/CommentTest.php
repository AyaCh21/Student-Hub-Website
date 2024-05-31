<?php

namespace App\Tests\Entity;

use App\Entity\Course;
use PHPUnit\Framework\TestCase;
use App\Entity\Comment;

class CommentTest extends TestCase
{
    public function testGetAndSetId()
    {
        $comment = new Comment();
        $comment->setId(123);
        $this->assertEquals(123, $comment->getId());
    }

    public function testGetAndSetCourseId()
    {
        $comment = new Comment();
        $course = new Course();
        $course->setId(456);
        $comment->setCourse($course);
        $this->assertEquals($course, $comment->getCourse());
    }

    public function testGetAndSetUserId()
    {
        $comment = new Comment();
        $comment->setUserId(789);
        $this->assertEquals(789, $comment->getUserId());
    }

    public function testGetAndSetType()
    {
        $comment = new Comment();
        $comment->setType('review');
        $this->assertEquals('review', $comment->getType());
    }

    public function testGetAndSetCommentText()
    {
        $comment = new Comment();
        $comment->setCommentText('This  comment.');
        $this->assertEquals('This  comment.', $comment->getCommentText());
    }

    public function testGetAndSetParentId()
    {
        $comment = new Comment();
        $comment->setParentId(321);
        $this->assertEquals(321, $comment->getParentId());
    }

    public function testGetAndSetCreatedAt()
    {
        $date = new \DateTime();
        $comment = new Comment();
        $comment->setCreatedAt($date);
        $this->assertEquals($date, $comment->getCreatedAt());
    }

    public function testGetAndSetUpdatedAt()
    {
        $date = new \DateTime();
        $comment = new Comment();
        $comment->setUpdatedAt($date);
        $this->assertEquals($date, $comment->getUpdatedAt());
    }

    public function testGetAndSetParent()
    {
        $parentComment = new Comment();
        $comment = new Comment();
        $comment->setParent($parentComment);
        $this->assertEquals($parentComment, $comment->getParent());
    }

    public function testGetAndAddChildren()
    {
        $comment = new Comment();
        $childComment = new Comment();
        $comment->addChild($childComment);
        $this->assertCount(1, $comment->getChildren());
        $this->assertEquals($childComment, $comment->getChildren()[0]);
    }

    public function testRemoveChild()
    {
        $comment = new Comment();
        $childComment = new Comment();
        $comment->addChild($childComment);
        $comment->removeChild($childComment);
        $this->assertCount(0, $comment->getChildren());
    }
}
