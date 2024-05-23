<?php

namespace App\Tests\Repository;

use App\Entity\ProfessorRate;
use App\Repository\ProfessorRateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

class ProfRateCalculatorTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private ManagerRegistry $managerRegistry;
    private QueryBuilder $queryBuilder;
    private Query $query;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $this->queryBuilder = $this->createMock(QueryBuilder::class);
        $this->query = $this->createMock(Query::class);
        $this->classMetadata = $this->createMock(ClassMetadata::class);

        $this->classMetadata->method('getName')
            ->willReturn(ProfessorRate::class);

        $this->entityManager->method('getClassMetadata')
            ->willReturn($this->classMetadata);

        $this->managerRegistry->method('getManagerForClass')
            ->willReturn($this->entityManager);
    }

    public function testGetAverage()
    {
        $professorId = 655;
        $expectedResult = (4 + 3 + 2) / 3;

        // Mock the QueryBuilder methods
        $this->queryBuilder->method('select')
            ->willReturn($this->queryBuilder);
        $this->queryBuilder->method('from')
            ->willReturn($this->queryBuilder);
        $this->queryBuilder->method('where')
            ->willReturn($this->queryBuilder);
        $this->queryBuilder->method('setParameter')
            ->willReturn($this->queryBuilder);
        $this->queryBuilder->method('getQuery')
            ->willReturn($this->query);

        // Mock the AbstractQuery method
        $this->query->method('getSingleScalarResult')
            ->willReturn($expectedResult);

        // Mock the createQueryBuilder method
        $this->entityManager->method('createQueryBuilder')
            ->willReturn($this->queryBuilder);

        $repository = new ProfessorRateRepository($this->managerRegistry);
        $result = $repository->getAverage($professorId);

        $this->assertEquals($expectedResult, $result);
    }

    public function testGetAverageNoRates()
    {
        $professorId = 655;

        // Mock the QueryBuilder methods
        $this->queryBuilder->method('select')
            ->willReturn($this->queryBuilder);
        $this->queryBuilder->method('from')
            ->willReturn($this->queryBuilder);
        $this->queryBuilder->method('where')
            ->willReturn($this->queryBuilder);
        $this->queryBuilder->method('setParameter')
            ->willReturn($this->queryBuilder);
        $this->queryBuilder->method('getQuery')
            ->willReturn($this->query);

        // Mock the AbstractQuery method
        $this->query->method('getSingleScalarResult')
            ->willReturn(null);

        // Mock the createQueryBuilder method
        $this->entityManager->method('createQueryBuilder')
            ->willReturn($this->queryBuilder);

        $repository = new ProfessorRateRepository($this->managerRegistry);
        $result = $repository->getAverage($professorId);

        $this->assertEquals("be the first to rate!", $result);
    }
}
