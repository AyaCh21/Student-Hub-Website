<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        if (($handle = fopen(__DIR__ . "/data/students.csv", 'r'))) {
            $headers = fgetcsv($handle, 1000, ',');

            while (($data = fgetcsv($handle, 1000, ',')) == true) {
                $student = new Student();
                $student->setUsername($data[0]);

                if (!$this->hasReference('student_' . $data[0])) {
                    // reference doesn't exist, so add it
                    $this->addReference('student_' . $data[0], $student);
                } else {
                    // reference already exists, so set it
                    $this->setReference('student_' . $data[0], $student);
                }

                $student->setEmail($data[1]);
                $student->setPassword($data[2]);
                $student->setPhase($data[3]);
                $student->setSpecialisation($data[4]);
                $manager->persist($student);
            }
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
