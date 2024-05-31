<?php

namespace App\Repository;

use App\Entity\ProfessorFeedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Feedback>
 *
 * @method ProfessorFeedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfessorFeedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfessorFeedback[]    findAll()
 * @method ProfessorFeedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackProfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfessorFeedback::class);
    }

    // Add custom methods if needed
}
