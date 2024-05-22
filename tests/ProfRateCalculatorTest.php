<?php

namespace App\Tests;

use App\Entity\Professor;
use App\Entity\ProfessorRate;
use App\Repository\ProfessorRateRepository;
use PHPUnit\Framework\TestCase;

class ProfRateCalculatorTest extends TestCase
{
    private ProfessorRateRepository $professorRateRepository;

    public function setUp(): void
    {
        $this->professorRateRepository = $this->createMock(ProfessorRateRepository::class);
    }

    public function testCalculateProfRate(): void
    {
        $prof = new Professor();
        $prof_name = 'Dr. Smith';
        $prof->setName($prof_name);

        $profRate1 = new ProfessorRate();
        $profRate1->setProfessor($prof);
        $profRate1->setRate(4.2);

        $profRate2 = new ProfessorRate();
        $profRate2->setProfessor($prof);
        $profRate2->setRate(3.8);

        $profRate3 = new ProfessorRate(); // Another student vote
        $profRate3->setProfessor($prof);
        $profRate3->setRate(4.5);

        $prof_rates = [$profRate1, $profRate2, $profRate3];

        $this->professorRateRepository->findBy($prof_name)->willReturn($prof_rates);

        $average_rate = calculateProfessorAverageRate($prof_name);

        $this->assertEquals(4.17,$average_rate,'prof rate calculator failed', 0.01);
    }

    private function calculateProfessorAverageRate(string $professorName): float
    {
        $totalRate = 0.0;
        $examCount = 0;

        // Retrieve exam rates from repository (replace with actual data retrieval if not mocking)
        $examRates = $this->professorRateRepository->findBy($professorName);

        foreach ($examRates as $examRate) {
            $totalRate += $examRate->getRate();
            $examCount++;
        }

        return $examCount > 0 ? $totalRate / $examCount : 0.0; // Handle cases with no exams
    }

}
