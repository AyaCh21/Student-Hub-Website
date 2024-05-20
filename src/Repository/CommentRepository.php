<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findByCourseAndType(int $courseId, string $type)
    {
        return $this->createQueryBuilder('c')
            ->where('c.course_id = :course_id')
            ->andWhere('c.type = :type')
            ->setParameter('course_id', $courseId)
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }

    public function findChildren(int $parentId)
    {
        return $this->createQueryBuilder('c')
            ->where('c.parent_id = :parent_id')
            ->setParameter('parent_id', $parentId)
            ->getQuery()
            ->getResult();
    }

}