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
                'books' => [
                    [
                        'title' => 'Book A1',
                        'author' => 'Author A1',
                        'description' => 'Description of Book A1',
                    ],
                    [
                        'title' => 'Book A2',
                        'author' => 'Author A2',
                        'description' => 'Description of Book A2',
                    ],
                ],
            ],
            [
                'name' => 'Phase 2',
                'books' => [
                    [
                        'title' => 'Book B1',
                        'author' => 'Author B1',
                        'description' => 'Description of Book B1',
                    ],
                    [
                        'title' => 'Book B2',
                        'author' => 'Author B2',
                        'description' => 'Description of Book B2',
                    ],
                ],
            ],
            [
                'name' => 'Phase 3',
                'books' => [
                    [
                        'title' => 'Book C1',
                        'author' => 'Author C1',
                        'description' => 'Description of Book C1',
                    ],
                    [
                        'title' => 'Book C2',
                        'author' => 'Author C2',
                        'description' => 'Description of Book C2',
                    ],
                ],
            ],
            [
                'name' => 'Phase 4',
                'books' => [
                    [
                        'title' => 'Book D1',
                        'author' => 'Author D1',
                        'description' => 'Description of Book D1',
                    ],
                    [
                        'title' => 'Book D2',
                        'author' => 'Author D2',
                        'description' => 'Description of Book D2',
                    ],
                ],
            ],
        ];

        return $this->render('study.html.twig', [
            'phases' => $phases,
        ]);
    }
}