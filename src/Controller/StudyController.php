<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudyController extends AbstractController
{
    /**
     * @Route("/study", name="study")
     */
    #[Route("/study", name:"study")]
    public function study(): Response
    {
        // Dummy data for demonstration
        $courses = [
            [
                'name' => 'Course A',
                'description' => 'Description of Course A',
                'materials' => [
                    ['title' => 'Lecture Material 1'],
                    ['title' => 'Lab Material 1'],
                ],
            ],
            [
                'name' => 'Course B',
                'description' => 'Description of Course B',
                'materials' => [
                    ['title' => 'Lecture Material 2'],
                    ['title' => 'Lab Material 2'],
                ],
            ],
            // Add more courses as needed
        ];

        return $this->render('study.html.twig', [
            'courses' => $courses,
        ]);
    }

}