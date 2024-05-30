<?php

namespace App\Repository;

use App\Entity\LabRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LabRate>
 *
 * @method LabRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method LabRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method LabRate[]    findAll()
 * @method LabRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class LabRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LabRate::class);
    }

    public function getAverageRatingForLab(int $courseId): array
    {
        $qb = $this->createQueryBuilder('lr');
        $qb->select('AVG(lr.rateValue) AS average, COUNT(lr.id) AS count')
            ->where('lr.course = :courseId')
            ->setParameter('courseId', $courseId);

        $result = $qb->getQuery()->getOneOrNullResult();

        return $result ? ['average' => $result['average'], 'count' => $result['count']] : ['average' => null, 'count' => 0];
    }

}