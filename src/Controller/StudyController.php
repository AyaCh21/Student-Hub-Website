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
        $phases = [

                [
                    'name' => 'Phase 1',
                    'courses' => [
                        'Course A1',
                        'Course A2',
                    ],
                ],
                [
                    'name' => 'Phase 2',
                    'courses' => [
                        'Course B1',
                        'Course B2',
                    ],
                ],
                [
                    'name' => 'Phase 3',
                    'courses' => [
                        'Course C1',
                        'Course C2',
                    ],
                ],
                [
                    'name' => 'Phase 4',
                    'courses' => [
                        'Course D1',
                        'Course D2',
                    ],
                ],
            ];

        return $this->render('study.html.twig', [
            'phases' => $phases,
        ]);
    }
}