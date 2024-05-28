<?php

namespace App\Repository;

use App\Entity\LabInstructor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LabInstructorRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LabInstructor::class);
    }


}
