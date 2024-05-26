<?php

namespace App\DataFixtures;

use App\Entity\ProfessorRate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProfessorRateFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        if (($handle = fopen(__DIR__."/data/professorrates.csv",'r'))) {
            $headers = fgetcsv($handle, 1000, ',');

            while (($data = fgetcsv($handle, 1000, ',')) == true) {
                $professor_rate = new ProfessorRate();

                $professorReference = 'professor_' . $data[0];
                if ($this->hasReference($professorReference)) {
                    $professor_rate->setProfessor($this->getReference($professorReference));
                } else {
                    throw new \Exception("Professor reference {$professorReference} not found.");
                }

                $studentReference = 'student_' . $data[1];
                if ($this->hasReference($studentReference)) {
                    $professor_rate->setStudent($this->getReference($studentReference));
                } else {
                    throw new \Exception("Student reference {$studentReference} not found.");
                }

                $professor_rate->setRate($data[2]);
                $manager->persist($professor_rate);
            }
            fclose($handle);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
