<?php
namespace App\Repository;

use App\Entity\ExamRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RatingExamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExamRate::class);
    }

    /**
     * Get average ratings for each course.
     *
     * @return array An array where keys are course IDs and values are average ratings.
     */
    public function getAverageRatings(): array
    {
        $qb = $this->createQueryBuilder('r');
        $qb->select('IDENTITY(r.course) AS course_id', 'AVG(r.rateValue) AS average', 'COUNT(r.id) AS count')
            ->groupBy('r.course');

        $query = $qb->getQuery();
        $results = $query->getResult();

        $averageRatings = [];
        foreach ($results as $result) {
            $averageRatings[$result['course_id']] = [
                'average' => $result['average'],
                'count' => $result['count']
            ];
        }

        return $averageRatings;
    }

    public function getAverageRatingForCourse(int $courseId): ?array
    {
        $qb = $this->createQueryBuilder('r');
        $qb->select('AVG(r.rateValue) AS average', 'COUNT(r.id) AS count')
            ->where('r.course = :course')
            ->setParameter('course', $courseId);

        $query = $qb->getQuery();
        $result = $query->getOneOrNullResult();

        return $result ? ['average' => $result['average'], 'count' => $result['count']] : null;
    }
}