<?php

namespace App\Repository;

use AllowDynamicProperties;
use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
#[AllowDynamicProperties] class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }
    /**
     * Retrieve Student_id based on username
     *
     * @param string $username
     * @return int|null
     */
    public function findStudentIdByUsername(string $username): ?int
    {
        $query = $this->createQueryBuilder('s')
            ->select('s.id')
            ->where('s.username = :username')
            ->setParameter('username', $username)
            ->getQuery();

        $result = $query->getOneOrNullResult();

        // Check if the result is not null before accessing its properties
        if ($result !== null) {
            return $result['id'];
        }

        return null;
    }
//public function createStudent(string $username, string $email, string $password, int $phase, string $specialization)
//{
//    $entityManager = $this->getEntityManager();
//    $student=new Student();
//    $student->setUsername($username);
//    $student->setEmail($email);
//    $student->setPassword($password);
//    $student->setPhase($phase);
//    $student->setSpecialization($specialization);
//}


//    /**
//     * @return Student[] Returns an array of Student objects
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

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
