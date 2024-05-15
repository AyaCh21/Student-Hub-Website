<?php
namespace App\Repository;

use App\Entity\rating_exam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RatingExamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, rating_exam::class);
    }

    /**
     * Get average ratings for each course.
     *
     * @return array An array where keys are course IDs and values are average ratings.
     */
    public function getAverageRatings(): array
    {
        $qb = $this->createQueryBuilder('r');
        $qb->select('r.courseId', 'AVG(r.rateValue) AS average')
            ->groupBy('r.courseId');

        $query = $qb->getQuery();
        $results = $query->getResult();

        $averageRatings = [];
        foreach ($results as $result) {
            // Use 'courseId' instead of 'course_id' and 'rateValue' instead of 'rate_value'
            $averageRatings[$result['courseId']] = $result['average'];
        }

        return $averageRatings;
    }
}