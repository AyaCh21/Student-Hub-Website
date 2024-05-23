<?php

namespace App\Tests\Repository;

use App\Entity\ProfessorRate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProfessorRateRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }


    public function testSearchByCategoryName()
    {
        $products = $this->entityManager
            ->getRepository(ProfessorRate::class)
            ->searchByCategoryName('Dr. Smith')
        ;

        $this->assertCount(3, $products);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    /**
     * {@inheritDoc}
     */
    protected static function getKernelClass(): string
    {
        // Specify the fully-qualified class name of your Symfony kernel
        return \App\Kernel::class;
    }

}
