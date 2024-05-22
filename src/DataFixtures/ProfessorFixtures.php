<?php

namespace App\DataFixtures;

use App\Entity\Professor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProfessorFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        if (($handle = fopen(__DIR__."/data/professors.csv",'r'))) {
            $headers = fgetcsv($handle, 1000, ',');

            while (($data = fgetcsv($handle, 1000, ',')) == true) {
                $professor = new Professor();
                $professor->setName($data[1]);
                //this can be referenced by courses
                if (!$this->hasReference('professor_' . $data[1])) {
                    // Reference doesn't exist, so add it
                    $this->addReference('professor_' . $data[1], $professor);
                } else {
                    // Reference already exists, so set it
                    $this->setReference('professor_' . $data[1], $professor);
                }                $manager->persist($professor);

            }

            fclose($handle);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
