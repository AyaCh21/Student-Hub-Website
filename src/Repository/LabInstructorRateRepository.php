<?php

namespace App\Repository;

use App\Entity\LabInstructorRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LabInstructorRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LabInstructorRate::class);
    }

    public function getAverageRatingForLabInstructor(int $labInstructorId): array
    {
        $qb = $this->createQueryBuilder('lir');
        $qb->select('AVG(lir.rateValue) AS average, COUNT(lir.id) AS count')
            ->where('lir.labInstructor = :labInstructorId')
            ->setParameter('labInstructorId', $labInstructorId);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result ? ['average' => $result['average'], 'count' => $result['count']] : ['average' => null, 'count' => 0];
    }

}