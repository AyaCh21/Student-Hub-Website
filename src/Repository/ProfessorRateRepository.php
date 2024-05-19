<?php

namespace App\Repository;

use App\Entity\professorRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProfessorRateRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfessorRate::class);
    }

    public function getAverage(int $professorId): float|string
    {
        $qb = $this->createQueryBuilder('pr');
        $qb->select($qb->expr()->avg('pr.rate_value'))
            ->from(ProfessorRate::class, 'professor_rate')
            ->where('professor_rate.professor = :professorId')
            ->setParameter('professorId', $professorId);

        $result = $qb->getQuery()->getSingleScalarResult();

        $show = is_null($result) ? "be the first to rate!" : $result;
        return $show;
    }
    //    /**
//     * @return ProfessorRate[] Returns an array of Course objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProfessorRate
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}