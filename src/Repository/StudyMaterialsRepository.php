<?php

namespace App\Repository;

use App\Entity\StudyMaterials;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudyMaterials>
 *
 * @method StudyMaterials|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudyMaterials|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudyMaterials[]    findAll()
 * @method StudyMaterials[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudyMaterialsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudyMaterials::class);
    }

//    /**
//     * @return StudyMaterials[] Returns an array of StudyMaterials objects
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

//    public function findOneBySomeField($value): ?StudyMaterials
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
