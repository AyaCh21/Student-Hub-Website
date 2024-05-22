<?php
namespace App\Repository;

use App\Entity\examRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RatingExamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, examRate::class);
    }

    /**
     * Get average ratings for each course.
     *
     * @return array An array where keys are course IDs and values are average ratings.
     */
    public function getAverageRatings(): array
    {
        $qb = $this->createQueryBuilder('r');
        $qb->select('r.courseId', 'AVG(r.rateValue) AS average', 'COUNT(r.id) AS count')
            ->groupBy('r.courseId');

        $query = $qb->getQuery();
        $results = $query->getResult();

        $averageRatings = [];
        foreach ($results as $result) {
            $averageRatings[$result['courseId']] = [
                'average' => $result['average'],
                'count' => $result['count']
            ];
        }

        return $averageRatings;
    }
}