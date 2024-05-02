<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudyController extends AbstractController
{
    private array $stylesheets;
    /**
     * @Route("/study", name="study")
     */
    #[Route("/study", name:"study")]
    public function study(EntityManagerInterface $entityManager, CourseRepository $courseRepository): Response
    {
        $courses = $courseRepository->findAll();
        $phaseWiseCourses = [];

        foreach ($courses as $course) {
            $phase = $course->getPhase();
            if (!isset($phaseWiseCourses[$phase])) {
                $phaseWiseCourses[$phase] = [];
            }
            $phaseWiseCourses[$phase][] = $course;
    }
        $this->stylesheets[]='study.css';

        return $this->render('study.html.twig', [
            'stylesheets' => $this->stylesheets,
            'phaseWiseCourses' => $phaseWiseCourses
        ]);
    }
}