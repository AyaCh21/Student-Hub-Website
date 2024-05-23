<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        if (($handle = fopen(__DIR__."/data/courses.csv",'r'))) {
            $headers = fgetcsv($handle,1000,',');

            while (($data = fgetcsv($handle,1000,',')) == true) {
                $course = new Course();

                $course->setName($data[1]);
                if (!$this->hasReference('course_' . $data[1])) {
                    $this->setReference('course_' . $data[1], $course);
                } else {
                    $this->setReference('course_' . $data[1], $course);
                }

                $professorReference = 'professor_' . $data[2];
                if ($this->hasReference($professorReference)) {
                    $course->setProfessor($this->getReference($professorReference));
                } else {
                    throw new \Exception("Professor reference {$professorReference} not found.");
                }

                $course->setPhase($data[3]);
                $course->setSemester($data[4]);
                $course->setSpecialisation($data[5]);
                $course->setEcts($data[6]);
                $course->setHasLab($data[7]);
                $manager->persist($course);
            }
            fclose($handle);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
