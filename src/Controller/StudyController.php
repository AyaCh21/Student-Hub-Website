<?php

namespace App\Controller;

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
    public function study(): Response
    {
        // Dummy data for demonstration
        $phases = [

            [
                'name' => 'Phase 1',
                'courses' => [
                    ['name' => 'Course A1'],
                    ['name' => 'Course A2'],
                ],
            ],
            [
                'name' => 'Phase 2',
                'courses' => [
                    ['name' => 'Course B1'],
                    ['name' => 'Course B2'],
                ],
            ],
            [
                'name' => 'Phase 3',
                'courses' => [
                    ['name' => 'Course C1'],
                    ['name' => 'Course C2'],
                    ['name' => 'Course C3'],
                ],
            ],
            [
                'name' => 'Phase 4',
                'courses' => [
                    ['name' => 'Course D1'],
                    ['name' => 'Course D2'],
                    ['name' => 'Course D3'],
                ],
            ],
        ];

        $this->stylesheets[]='study.css';

        return $this->render('study.html.twig', [
            'phases' => $phases,
            'stylesheets' => $this->stylesheets
        ]);
    }
}