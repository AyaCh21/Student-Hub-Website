<?php

namespace App\DataFixtures;

use App\Entity\ExamRate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CourseRateFixture extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        if (($handle = fopen(__DIR__."/data/courserates.csv",'r'))) {
            $headers = fgetcsv($handle, 1000, ',');

            while (($data = fgetcsv($handle, 1000, ',')) == true) {
                $course_rate = new ExamRate();

                $courseReference = 'course_' . $data[0];
                if ($this->hasReference($courseReference)) {
                    $course_rate->setCourse($this->getReference($courseReference));
                } else {
                    throw new \Exception("Course reference {$courseReference} not found.");
                }

                $studentReference = 'student_' . $data[1];
                if ($this->hasReference($studentReference)) {
                    $course_rate->setStudent($this->getReference($studentReference));
                } else {
                    throw new \Exception("Student reference {$studentReference} not found.");
                }

                $course_rate->setRateValue($data[2]);
                $manager->persist($course_rate);
            }
            fclose($handle);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}
