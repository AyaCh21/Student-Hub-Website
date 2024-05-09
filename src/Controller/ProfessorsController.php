<?php

namespace App\Controller;

use App\Entity\Professor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
class ProfessorsController extends AbstractController
{
    #[Route("/prof_list", name:"profs")]
    public function list_professors(EntityManagerInterface $entityManager): Response
    {
        $professors = $entityManager->getRepository(Professor::class)->findAll();

        return $this->render('professors.html.twig',[
            'professors' => $professors
        ]);
    }
}