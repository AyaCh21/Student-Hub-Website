<?php

namespace App\Repository;

use App\Entity\professorRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ProfessorRateRepository extends ServiceEntityRepository
{
    private ManagerRegistry $registry;
    private QueryBuilder $qb;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
        //parent::__construct($this->registry, ProfessorRate::class);
    }

    public function getAverage(int $professorId): float|string
    {
        $qb = $this->createQueryBuilder('pr');
        $qb->select($qb->expr()->avg('pr.rateValue'))
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
    /*public function getAverageRatingForProfessor(int $professorId): ?array
    {
        $qb = $this->createQueryBuilder('pr');
        $qb->select('AVG(pr.rate) AS average', 'COUNT(pr.id) AS count')
            ->where('pr.professor = :professorId')
            ->setParameter('professorId', $professorId);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result ? ['average' => $result['average'], 'count' => $result['count']] : null;
    }*/

    /*public function getAverageRatingForProfessor(int $professorId): float|string
    {
        $qb = $this->createQueryBuilder('pr');
        $qb->select('AVG(pr.rateValue) AS average, COUNT(pr.id) AS count')
            ->where('pr.professor = :professorId')
            ->setParameter('professorId', $professorId);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result ? ['average' => $result['average'], 'count' => $result['count']] : 'be the first to rate!';
    }*/

    public function getAverageRatingForProfessor(int $professorId): array
    {
        $qb = $this->createQueryBuilder('pr');
        $qb->select('AVG(pr.rateValue) AS average, COUNT(pr.id) AS count')
            ->where('pr.professor = :professorId')
            ->setParameter('professorId', $professorId);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result ? ['average' => $result['average'], 'count' => $result['count']] : ['average' => null, 'count' => 0];
    }



}