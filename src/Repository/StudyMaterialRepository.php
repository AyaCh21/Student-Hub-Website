<?php

namespace App\Repository;

use App\Entity\StudyMaterial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudyMaterial>
 *
 * @method StudyMaterial|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudyMaterial|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudyMaterial[]    findAll()
 * @method StudyMaterial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudyMaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudyMaterial::class);
    }

//    /**
//     * @return StudyMaterial[] Returns an array of StudyMaterial objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StudyMaterial
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
