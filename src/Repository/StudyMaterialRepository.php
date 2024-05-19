<?php

namespace App\Repository;

use App\Entity\StudyMaterial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
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
}