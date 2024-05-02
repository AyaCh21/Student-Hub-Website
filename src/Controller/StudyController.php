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
                    ['name' => 'Course A1',
//                        'pdf' => 'http://a23www301.studev.groept.be/DeleAyeni_Transistor_Lab3_Prep.pdf'
                    'pdf' => null
                    ],
                    ['name' => 'Course A2',
                        'pdf' => null
                    ],
                ],
            ],
            [
                'name' => 'Phase 2',
                'courses' => [
                    ['name' => 'Course B1',
                        'pdf' => 'http://a23www301.studev.groept.be/TDI_Lab_1.pdf'
                        ],
                    ['name' => 'Course B2',
                        'pdf' => null
                    ],
                ],
            ],
            [
                'name' => 'Phase 3',
                'courses' => [
                    ['name' => 'Course C1',
                        'pdf' => null
                    ],
                    ['name' => 'Course C2',
                        'pdf' => null
                    ],
                    ['name' => 'Course C3',
                        'pdf' => null
                    ],
                ],
            ],
            [
                'name' => 'Phase 4',
                'courses' => [
                    ['name' => 'Course D1',
                        'pdf' => null
                    ],
                    ['name' => 'Course D2',
                        'pdf' => null
                    ],
                    ['name' => 'Course D3',
                        'pdf' => null
                    ],
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